<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index()
    {
        $memos =Memo::where("user_id", Auth::id())->orderBy("updated_at", "desc")->get();
        return view("/memo", [
            "name" => $this->getLoginUserName(),
            "memos" => $memos
        ]);
    }

    public function add()
    {
        Memo::create([
            // Auth::id()は現在ログインしているユーザーのIDを取得する
            "user_id" => Auth::id(),
            "title" => "新規メモ",
            "content" => "",
        ]);
        return redirect()->route("memo.index");
    }

    private function getLoginUserName() {
        $user = Auth::user();
        $name = "";
        if ($user) {
            if (mb_strlen($user->name) > 7) {
                $name = mb_substr($user->name, 0, 7) . "...";
            } else {
                $name = $user->name;
            }
        }
        return $name;
    }
}
