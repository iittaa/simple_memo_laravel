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
            "memos" => $memos,
            "select_memo" => session()->get("select_memo"),
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

    private function getLoginUserName()
    {
        // ログインしているユーザーを取得する
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

    public function select(Request $request)
    {
        $memo = Memo::find($request->id);
        session()->put("select_memo", $memo);

        return redirect()->route("memo.index");
    }

    public function update(Request $request)
    {
        $memo = Memo::find($request->edit_id);
        $memo->title = $request->edit_title;
        $memo->content = $request->edit_content;

        if ($memo->update()) {
            session()->put("select_memo", $memo);
        } else {
            session()->remove("select_memo");
        }
        return redirect()->route("memo.index");
    }

    public function delete(Request $request)
    {
        Memo::find($request->edit_id)->delete();
        session()->remove("select_memo");
        return redirect()->route("memo.index");
    }
}
