<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Berita;
use Carbon\Carbon;

class HomeWebController extends Controller
{
    public function index()
    {
        // Cache site configuration for 1 hour
        $konf = Cache::remember('site_config', 3600, function() {
            return DB::table('setting')->first();
        });
        
        // Cache homepage data for 30 minutes
        $data = Cache::remember('homepage_data', 1800, function() {
            return [
                'layanan' => DB::table('layanan')->select('nama_layanan', 'gambar_layanan', 'keterangan_layanan')->get(),
                'testimonial' => DB::table('testimonial')->select('judul_testimonial', 'gambar_testimonial', 'deskripsi_testimonial', 'jabatan')->get(),
                'galeri' => DB::table('galeri')->select('nama_galeri', 'gambar_galeri', 'gambar_galeri1', 'gambar_galeri2', 'gambar_galeri3', 'video_galeri')->orderBy('created_at', 'desc')->limit(12)->get(),
                'article' => DB::table('berita')->select('judul_berita', 'slug_berita', 'gambar_berita', 'isi_berita', 'tanggal_berita', 'kategori_berita', 'meta_description', 'tags')->orderBy('tanggal_berita', 'desc')->limit(4)->get(),
                'award' => DB::table('award')->select('nama_award', 'gambar_award', 'keterangan_award')->get(),
                'projects' => DB::table('project')->select('nama_project', 'slug_project', 'gambar_project', 'keterangan_project', 'jenis_project')->orderBy('created_at', 'desc')->limit(9)->get(),
            ];
        });
        
        // Cache project types
        $jenis_projects = Cache::remember('project_types', 3600, function() {
            return DB::table('project')->distinct()->pluck('jenis_project')->filter()->values()->toArray();
        });
        
        // Extract cached data
        $layanan = $data['layanan'];
        $testimonial = $data['testimonial'];
        $galeri = $data['galeri'];
        $article = $data['article'];
        $award = $data['award'];
        $projects = $data['projects'];
        
        return view('welcome', compact('konf', 'layanan', 'testimonial', 'galeri', 'article', 'award', 'projects', 'jenis_projects'));
    }

    public function portfolio()
    {
        $konf = Cache::remember('site_config', 3600, function() {
            return DB::table('setting')->first();
        });
        
        $projects = Cache::remember('all_projects', 1800, function() {
            return DB::table('project')->select('nama_project', 'slug_project', 'gambar_project', 'keterangan_project', 'jenis_project')->get();
        });
        
        $jenis_projects = Cache::remember('project_types', 3600, function() {
            return DB::table('project')->distinct()->pluck('jenis_project')->filter()->values()->toArray();
        });
        
        return view('portfolio', compact('konf', 'projects','jenis_projects'));
    }

    public function gallery()
    {
        $konf = Cache::remember('site_config', 3600, function() {
            return DB::table('setting')->first();
        });
        
        return view('gallery', compact('konf'));
    }

    public function portfolioDetail($slug)
    {
        $konf = Cache::remember('site_config', 3600, function() {
            return DB::table('setting')->first();
        });
        
        $portfolio = Cache::remember("portfolio_{$slug}", 1800, function() use ($slug) {
            return DB::table('project')->where('slug_project', $slug)->first();
        });
        
        if (!$portfolio) {
            abort(404, 'Portfolio not found');
        }
        
        return view('portfolio_detail', compact('konf', 'portfolio'));
    }

    public function articleDetail($slug)
    {
        $konf = Cache::remember('site_config', 3600, function() {
            return DB::table('setting')->first();
        });
        
        // Get article without cache for view counting
        $article = DB::table('berita')->where('slug_berita', $slug)->first();
        
        if (!$article) {
            abort(404, 'Article not found');
        }
        
        // Convert article to model instance if needed for relationships
        $articleModel = Berita::find($article->id_berita);
        
        // Increment view count
        DB::table('berita')
            ->where('id_berita', $article->id_berita)
            ->increment('views');
        
        // Track visitor geo location (optional)
        $this->trackVisitor($article->id_berita);
        
        // Get related articles
        $recent_articles = Cache::remember('recent_articles_' . $article->kategori_berita, 900, function() use ($article) {
            return DB::table('berita')
                ->select('judul_berita', 'slug_berita', 'gambar_berita', 'tanggal_berita', 'kategori_berita', 'created_at', 'isi_berita')
                ->where('kategori_berita', $article->kategori_berita)
                ->where('id_berita', '!=', $article->id_berita)
                ->orderBy('tanggal_berita', 'desc')
                ->limit(3)
                ->get();
        });
        
        // If we have specific related IDs, get those too
        if ($articleModel && $articleModel->related_ids && count($articleModel->related_ids) > 0) {
            $related_articles = DB::table('berita')
                ->whereIn('id_berita', $articleModel->related_ids)
                ->select('judul_berita', 'slug_berita', 'isi_berita')
                ->get();
            $article->related_articles = $related_articles;
        }

        return view('article_detail', compact('konf', 'article', 'recent_articles'));
    }

    public function articles(Request $request)
    {
        $konf = Cache::remember('site_config', 3600, function() {
            return DB::table('setting')->first();
        });
        
        $query = DB::table('berita')
            ->select('judul_berita', 'slug_berita', 'gambar_berita', 'isi_berita', 'tanggal_berita', 'kategori_berita', 'meta_description', 'tags', 'reading_time', 'views')
            ->orderBy('tanggal_berita', 'desc');
        
        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('kategori_berita', $request->category);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_berita', 'LIKE', "%{$search}%")
                  ->orWhere('isi_berita', 'LIKE', "%{$search}%")
                  ->orWhere('tags', 'LIKE', "%{$search}%")
                  ->orWhere('meta_description', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by tag
        if ($request->has('tag') && $request->tag) {
            $tag = $request->tag;
            $query->where('tags', 'LIKE', "%{$tag}%");
        }
        
        $articles = $query->paginate(10);
        
        // Get categories for filter
        $categories = DB::table('berita')
            ->select('kategori_berita')
            ->distinct()
            ->whereNotNull('kategori_berita')
            ->pluck('kategori_berita');
        
        // Get popular tags
        $popular_tags = $this->getPopularTags();
            
        return view('articles', compact('konf', 'articles', 'categories', 'popular_tags'));
    }
    
    /**
     * Track visitor information
     */
    private function trackVisitor($articleId)
    {
        try {
            $ip = request()->ip();
            $userAgent = request()->userAgent();
            
            // Check if visitor already viewed this article today
            $exists = DB::table('berita_visits')
                ->where('article_id', $articleId)
                ->where('ip_address', $ip)
                ->whereDate('created_at', Carbon::today())
                ->exists();
            
            if (!$exists) {
                // Try to get geo information (optional, requires external API)
                $geoData = $this->getGeoData($ip);
                
                DB::table('berita_visits')->insert([
                    'article_id' => $articleId,
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'country' => $geoData['country'] ?? null,
                    'city' => $geoData['city'] ?? null,
                    'region' => $geoData['region'] ?? null,
                    'latitude' => $geoData['lat'] ?? null,
                    'longitude' => $geoData['lon'] ?? null,
                    'created_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't break the page
            \Log::error('Failed to track visitor: ' . $e->getMessage());
        }
    }
    
    /**
     * Get geo data from IP (optional)
     */
    private function getGeoData($ip)
    {
        // Skip for localhost
        if ($ip == '127.0.0.1' || $ip == '::1') {
            return [
                'country' => 'Local',
                'city' => 'Localhost',
                'region' => 'Local',
            ];
        }
        
        try {
            // Using ip-api.com (free tier: 45 requests per minute)
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,lat,lon");
            
            if ($response) {
                $data = json_decode($response, true);
                if ($data && $data['status'] == 'success') {
                    return [
                        'country' => $data['country'] ?? null,
                        'city' => $data['city'] ?? null,
                        'region' => $data['regionName'] ?? null,
                        'lat' => $data['lat'] ?? null,
                        'lon' => $data['lon'] ?? null,
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get geo data: ' . $e->getMessage());
        }
        
        return [];
    }
    
    /**
     * Get popular tags from articles
     */
    private function getPopularTags($limit = 10)
    {
        $allTags = DB::table('berita')
            ->whereNotNull('tags')
            ->pluck('tags');
        
        $tagCounts = [];
        
        foreach ($allTags as $tagString) {
            $tags = array_map('trim', explode(',', $tagString));
            foreach ($tags as $tag) {
                if (!empty($tag)) {
                    if (!isset($tagCounts[$tag])) {
                        $tagCounts[$tag] = 0;
                    }
                    $tagCounts[$tag]++;
                }
            }
        }
        
        arsort($tagCounts);
        
        return array_slice($tagCounts, 0, $limit, true);
    }
    
    /**
     * Generate sitemap
     */
    public function sitemap()
    {
        $urls = collect([
            ['url' => url('/'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['url' => url('/portfolio'), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['url' => url('/gallery'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => url('/articles'), 'changefreq' => 'weekly', 'priority' => '0.8'],
        ]);
        
        // Add articles
        $articles = DB::table('berita')
            ->select('slug_berita', 'updated_at')
            ->get();
            
        foreach ($articles as $article) {
            $urls->push([
                'url' => url('/article/' . $article->slug_berita),
                'changefreq' => 'monthly',
                'priority' => '0.6',
                'lastmod' => $article->updated_at,
            ]);
        }
        
        // Add projects
        $projects = DB::table('project')
            ->select('slug_project', 'updated_at')
            ->get();
            
        foreach ($projects as $project) {
            $urls->push([
                'url' => url('/portfolio/' . $project->slug_project),
                'changefreq' => 'monthly',
                'priority' => '0.7',
                'lastmod' => $project->updated_at,
            ]);
        }
        
        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}