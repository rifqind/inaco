<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\Homebanner;
use App\Models\HomebannerTranslation;
use App\Models\InternationalMarket;
use App\Models\NewsTranslation;
use App\Models\OfficialSocmedMarketplace;
use App\Models\PageTranslation;
use App\Models\Product;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductImage;
use App\Models\ProductSegment;
use App\Models\ProductTranslation;
use App\Models\RecipeImage;
use App\Models\RecipeTranslation;
use App\Models\SubpageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    //
    public function index(Request $request, string $id, string $title = null)
    {
        $code = 'id';
        $data = $this->newsGenerate($request, $code, $id, $title);
        if ($title) {
            $show = $this->newsGenerate($request, $code, $id, $title);
            if ($data['news_category'] == 1) {
                return view('web.news-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            } else {
                return view('web.press-release-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            }
        }

        if ($data['news_category'] == 1) {
            return view('web.news', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        } else {
            return view('web.press-release', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        }
    }


    public function news(Request $request, string $code = null, string $id, string $title = null)
    {
        $code ??= 'id';
        if ($code == 'id') {
            ($id == 'articles') ? $id = 'artikel' : $id;
            // dd($request->all());
            $link = route('web.id.berita', [
                'id' => $id,
                'title' => $title,
                'currentPage' => $request->currentPage,
                'paginated' => $request->paginated
            ]);
            // dd($link);
            return redirect($link);
        }
        $data = $this->newsGenerate($request, $code, $id, $title);
        if ($title) {
            $show = $this->newsGenerate($request, $code, $id, $title);
            if ($data['news_category'] == 1) {
                return view('web.news-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            } else {
                return view('web.press-release-detail', [
                    'news' => $show['news'],
                    'id' => $show['id'],
                    'newsList' => $show['newsList'],
                    'code' => $show['code'],
                ]);
            }
        }
        if ($data['news_category'] == 1) {
            return view('web.news', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        } else {
            return view('web.press-release', [
                'news' => $data['news'],
                'id' => $data['id'],
                'code' => $data['code'],
                'popularNews' => $data['popularNews'],
                'page' => $data['page'],
                'section' => $data['section']
            ]);
        }
    }


    private function newsGenerate(Request $request, string $code = null, string $id, string $title = null)
    {
        $paginated = $request->paginated ?? 4;
        $currentPage = $request->currentPage ?? 1;
        //recheck
        if ($code == 'id')
            $news_category = $id === 'artikel' ? 1 : ($id === 'press-release' ? 2 : null);
        else
            $news_category = $id === 'articles' ? 1 : ($id === 'press-release' ? 2 : null);
        if (!$news_category)
            abort(404);

        $page = PageTranslation::where('language_code', $code)
            ->join('pages as sb', 'sb.pages_id', '=', 'pages_translation.pages_id')
            ->where('pages_slug', 'berita')
            ->where('pages_status', 1)
            ->first();
        $section = $page ? SubpageTranslation::where('language_code', $code)
            ->join('sub_pages as sb', 'sb.sub_pages_id', '=', 'sub_pages_translation.sub_pages_id')
            ->where('sub_pages_slug', 'like', ($news_category == 1) ? 'berita-bagian-%' : 'press-bagian-%')
            ->where('sb.pages_id', $page->pages_id)
            ->where('sb.sub_pages_status', 1)
            ->get() : collect([]);

        // dd($section);
        $query = NewsTranslation::query()
            ->where('language_code', $code)
            ->join('news as n', 'n.news_id', '=', 'news_translation.news_id')
            ->where('n.news_status', 1)
            ->where('n.news_category', $news_category)
            ->orderBy('n.create_date', 'desc')
            ->select([
                'news_translation.news_title',
                'news_translation.news_description',
                'n.create_date',
                'n.news_image',
                'count_views',
                'news_slug'
            ]);
        if ($title) {
            $news = $this->getNewsDetail($title);
            $newsList = $this->paginateAndFormatNews($query, 2);
            $show = [];
            $show['news'] = $news;
            $show['id'] = $id == 'artikel' ? 'articles' : $id;
            $show['newsList'] = $newsList;
            $show['code'] = $code;
            $show['news_category'] = $news_category;
            return $show;
        }

        $news = $this->paginateAndFormatNews($query, $paginated, $currentPage);
        $popular = $query->orderBy('count_views', 'desc');
        $popularNews = $this->paginateAndFormatNews($popular, $paginated, $currentPage);
        $data = [];
        $data['news'] = $news;
        $data['id'] = $id == 'artikel' ? 'articles' : $id;
        $data['code'] = $code;
        $data['popularNews'] = $popularNews;
        $data['page'] = $page;
        $data['section'] = $section;
        $data['news_category'] = $news_category;
        return $data;
    }

    private function getNewsDetail($slug)
    {
        $news = NewsTranslation::where('news_slug', $slug)
            ->join('news as n', 'n.news_id', '=', 'news_translation.news_id')
            ->first([
                'news_translation.news_title',
                'news_translation.news_description',
                'n.create_date',
                'n.news_image',
                'count_views',
                'news_slug'
            ]);

        $sessionKey = 'news_viewed_' . $news->news_slug;
        // dd(session()->all());
        if (!session($sessionKey)) {
            $news->count_views = $news->count_views + 1;
            NewsTranslation::where('news_slug', $slug)->update(['count_views' => $news->count_views]);
            session()->put($sessionKey, true);
        }

        $news->create_date = $this->formatDate($news->create_date);

        return $news;
    }

    private function paginateAndFormatNews($query, $paginated, $currentPage = 1)
    {
        $newsList = $query->paginate($paginated, ['*'], 'page', $currentPage);

        foreach ($newsList as $news) {
            $news->news_description = $this->formatDescription($news->news_description);
            $news->create_date = $this->formatDate($news->create_date);
        }

        return $newsList;
    }
   

    private function formatDescription($description)
    {
        $cleanText = strip_tags(html_entity_decode($description));
        $words = explode(' ', $cleanText);

        return count($words) > 17
            ? implode(' ', array_slice($words, 0, 17)) . '...'
            : $cleanText;
    }

    private function formatDate($date)
    {
        return date('d M Y', strtotime($date));
    }
}
