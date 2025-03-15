<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\View; 

class MemberController extends Controller
{
    public function index()
    {
        $currentMembers = Member::where('graduation', 0)->get()->groupBy('grade');
        $graduatedMembers = Member::where('graduation', 1)->get()->groupBy('grade');
        return view('members.index', compact('currentMembers', 'graduatedMembers'));
    }

    public function show($id)
    {
        $member = Member::with('songs')->findOrFail($id); // メンバー情報と参加楽曲を取得
        
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
            $blogHtml = 'ブログがありません。';
        }

        return view('members.show', compact('member', 'blogHtml'));
    }
}