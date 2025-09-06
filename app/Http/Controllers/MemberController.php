<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\View; 

class MemberController extends Controller
{
    public function index(Request $request)
{
    $sort = $request->input('sort', 'default');
    $order = $request->input('order', 'desc');

    if ($sort === 'default') {
        // デフォルト: gradeごとに表示
        $currentMembers = Member::where('graduation', 0)->get()->groupBy('grade');
        $graduatedMembers = Member::where('graduation', 1)->get()->groupBy('grade');
    } else {
        // gradeを無視してソート
        $currentMembers = Member::where('graduation', 0)->orderBy($sort, $order)->get()->map(function ($member) use ($sort) {
            if ($sort === 'birthday') {
                $member->additional_info = \Carbon\Carbon::parse($member->birthday)->format('Y年m月d日');
            } elseif ($sort === 'height') {
                $member->additional_info = $member->height."cm";
            } elseif ($sort === 'furigana') {
                $member->additional_info = $member->furigana;
            } elseif ($sort === 'birthplace') {
                $member->additional_info = $member->birthplace;
            }
            return $member;
        });
        if ($sort === 'blood_type') {
            $currentMembers = Member::where('graduation', 0)
                ->orderByRaw("FIELD(blood_type, 'A型', 'B型', 'O型', 'AB型', '不明')")
                ->get()
                ->map(function ($member) {
                    $member->additional_info = $member->blood_type;
                    return $member;
                });
        }
        $graduatedMembers = Member::where('graduation', 1)->orderBy($sort, $order)->get()->map(function ($member) use ($sort) {
            if ($sort === 'birthday') {
                $member->additional_info = \Carbon\Carbon::parse($member->birthday)->format('Y年m月d日');
            } elseif ($sort === 'height') {
                $member->additional_info = $member->height."cm";
            } elseif ($sort === 'furigana') {
                $member->additional_info = $member->furigana;
            } elseif ($sort === 'birthplace') {
                $member->additional_info = $member->birthplace;
            }
            return $member;
        });
        if ($sort === 'blood_type') {
            $graduatedMembers = Member::where('graduation', 1)
                ->orderByRaw("FIELD(blood_type, 'A型', 'B型', 'O型', 'AB型', '不明')")
                ->get()
                ->map(function ($member) {
                    $member->additional_info = $member->blood_type;
                    return $member;
                });
        }
    }

    return view('members.index', compact('currentMembers', 'graduatedMembers', 'sort', 'order'));
}
    public function show($id)
    {
        $member = Member::with('songs')->findOrFail($id); // メンバー情報と参加楽曲を取得
        $songCount = $member->songs->count();
        $centerCount = $member->songs->where('pivot.is_center', true)->count(); // センター回数を取得
        $titlesongCount = $member->songs->where('titlesong', 1)->count(); // 選抜回数を取得
        $radar = Member::with('skill')->find($id);
        
        // レーダーチャート用データ（例: 各スキル 100 点満点）
        $radarData = [
            'singing' => $radar->singing,
            'dancing' => $radar->dancing,
            'variety' => $radar->variety,
            'intelligence' => $radar->intelligence,
            'sport' => $radar->sport,
            'burikko' => $radar->burikko,
        ];
        
        if ($radar === null) {
            $radar = 50;
        };

        if ($member->blog_url) {
            $client = new Client();
            try {
                $response = $client->request('GET', $member->blog_url);
                $html = $response->getBody()->getContents();
    
                $crawler = new Crawler($html);
                $title = $crawler->filter('.c-blog-article__title')->text();
                $content = $crawler->filter('.c-blog-article__text')->text();
                $time = $crawler->filter('.c-blog-article__date')->text();
    
                $blogHtml = "<a href='{$member->blog_url}' target='_blank' rel='noopener noreferrer'>{$time}&nbsp;{$title}</a>";
            } catch (\Exception $e) {
                $blogHtml = 'ブログ情報の取得に失敗しました。';
            }
        } else {
            $blogHtml = 'ブログは終了しました。';
        }

        return view('members.show', compact('member',  'centerCount','titlesongCount', 'songCount', 'blogHtml', 'radarData', 'radar'));
    }
}