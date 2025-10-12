<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class MemberController extends Controller
{

    public function index(Request $request)
{
    $sort  = $request->input('sort', 'default');
    $order = $request->input('order', 'asc');

    if ($sort === 'default') {
        $currentMembers   = Member::where('graduation', 0)->get()->groupBy('grade');
        $graduatedMembers = Member::where('graduation', 1)->get()->groupBy('grade');

        return view('members.index', compact('currentMembers', 'graduatedMembers', 'sort', 'order'));
    }

    $baseQuery = function ($graduation) use ($sort, $order) {
        $q = Member::query()->where('graduation', $graduation);

        $q->withCount([
            'songs as songs_count',

            'songs as titlesongs_count' => function ($q2) {
                $q2->where('titlesong', 1);
            },

            'songs as center_count' => function ($q3) {
                $q3->where('song_members.is_center', 1);
            },
        ]);

        switch ($sort) {
            case 'songs':
                $q->orderBy('songs_count', $order);
                break;
            case 'titlesongs':
                $q->orderBy('titlesongs_count', $order);
                break;
            case 'center':
                $q->orderBy('center_count', $order);
                break;

            case 'birth':
            case 'height':
            case 'furigana':
            case 'birthplace':
                $q->orderBy($sort, $order);
                break;

            case 'blood':
                $q->orderByRaw("FIELD(blood, 'A型','B型','O型','AB型','不明')")
                  ->orderBy('furigana'); // 同順位の二次キーはお好みで
                break;

            default:
                $q->orderBy('id', 'asc');
        }

        return $q->get()->map(function ($member) use ($sort) {
            if ($sort === 'birth') {
                $member->additional_info = \Carbon\Carbon::parse($member->birth)->format('Y年m月d日');
            } elseif ($sort === 'height') {
                $member->additional_info = $member->height . 'cm';
            } elseif ($sort === 'furigana') {
                $member->additional_info = $member->furigana;
            } elseif ($sort === 'birthplace') {
                $member->additional_info = $member->birthplace;
            } elseif ($sort === 'blood') {
                $member->additional_info = $member->blood;
            } elseif ($sort === 'songs') {
                $member->additional_info = '参加楽曲数: ' . ($member->songs_count ?? 0);
            } elseif ($sort === 'titlesongs') {
                $member->additional_info = '表題曲参加: ' . ($member->titlesongs_count ?? 0);
            } elseif ($sort === 'center') {
                $member->additional_info = 'センター回数: ' . ($member->center_count ?? 0);
            }
            return $member;
        });
    };

    $currentMembers   = $baseQuery(0);
    $graduatedMembers = $baseQuery(1);

    return view('members.index', compact('currentMembers', 'graduatedMembers', 'sort', 'order'));
}

//     public function index(Request $request)
// {
//     $sort = $request->input('sort', 'default');
//     $order = $request->input('order', 'desc');

//     if ($sort === 'default') {
//         // デフォルト: gradeごとに表示
//         $currentMembers = Member::where('graduation', 0)->get()->groupBy('grade');
//         $graduatedMembers = Member::where('graduation', 1)->get()->groupBy('grade');
//     } else {
//         $currentMembers = Member::where('graduation', 0)->orderBy($sort, $order)->get()->map(function ($member) use ($sort) {
//             if ($sort === 'birth') {
//                 $member->additional_info = \Carbon\Carbon::parse($member->birth)->format('Y年m月d日');
//             } elseif ($sort === 'height') {
//                 $member->additional_info = $member->height."cm";
//             } elseif ($sort === 'furigana') {
//                 $member->additional_info = $member->furigana;
//             } elseif ($sort === 'birthplace') {
//                 $member->additional_info = $member->birthplace;
//             } elseif ($sort === 'songs') {
//                 $member->additional_info = $member->songs;
//             } elseif ($sort === 'titlesong') {
//                 $member->additional_info = $member->titlesong;
//             } elseif ($sort === 'center') {
//                 $member->additional_info = $member->center;
//             }
//             return $member;
//         });
//         if ($sort === 'blood') {
//             $currentMembers = Member::where('graduation', 0)
//                 ->orderByRaw("FIELD(blood, 'A型', 'B型', 'O型', 'AB型', '不明')")
//                 ->get()
//                 ->map(function ($member) {
//                     $member->additional_info = $member->blood;
//                     return $member;
//                 });
//         }
//         $graduatedMembers = Member::where('graduation', 1)->orderBy($sort, $order)->get()->map(function ($member) use ($sort) {
//             if ($sort === 'birth') {
//                 $member->additional_info = \Carbon\Carbon::parse($member->birth)->format('Y年m月d日');
//             } elseif ($sort === 'height') {
//                 $member->additional_info = $member->height."cm";
//             } elseif ($sort === 'furigana') {
//                 $member->additional_info = $member->furigana;
//             } elseif ($sort === 'birthplace') {
//                 $member->additional_info = $member->birthplace;
//             } elseif ($sort === 'songs') {
//                 $member->additional_info = $member->songs;
//             } elseif ($sort === 'titlesong') {
//                 $member->additional_info = $member->titlesong;
//             } elseif ($sort === 'center') {
//                 $member->additional_info = $member->center;
//             }
//             return $member;
//         });
//         if ($sort === 'blood') {
//             $graduatedMembers = Member::where('graduation', 1)
//                 ->orderByRaw("FIELD(blood, 'A型', 'B型', 'O型', 'AB型', '不明')")
//                 ->get()
//                 ->map(function ($member) {
//                     $member->additional_info = $member->blood;
//                     return $member;
//                 });
//         }
//     }

//     return view('members.index', compact('currentMembers', 'graduatedMembers', 'sort', 'order'));
// }
    public function show($id)
    {
        $member = Member::with('songs')->findOrFail($id); // メンバー情報と参加楽曲を取得
        $songCount = $member->songs->count();
        $centerCount = $member->songs->where('pivot.is_center', true)->count(); // センター回数を取得
        $titlesongCount = $member->songs->where('titlesong', 1)->count(); // 選抜回数を取得
        $radar = Member::with('skill')->find($id);
        
        // レーダーチャート用データ（例: 各スキル 100 点満点）
        // $radarData = [
        //     'singing' => $radar->singing,
        //     'dancing' => $radar->dancing,
        //     'variety' => $radar->variety,
        //     'intelligence' => $radar->intelligence,
        //     'sport' => $radar->sport,
        //     'burikko' => $radar->burikko,
        // ];
        
        // if ($radar === null) {
        //     $radar = 50;
        // };

        // ブログ取得
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

        return view('members.show', compact('member',  'centerCount','titlesongCount', 'songCount', 'blogHtml'));
        // return view('members.show', compact('member',  'centerCount','titlesongCount', 'songCount', 'blogHtml', 'radarData', 'radar'));
    }
}