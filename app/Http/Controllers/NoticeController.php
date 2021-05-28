<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/23/2021
 * Time: 6:54 AM
 */

namespace App\Http\Controllers;

use App\Notice;
use App\NoticeImage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Get data of all Notices
     *
     * @return array
     */
    public function index():array
    {
        return Notice::all();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'textNotice' => 'required|string|max:255',

        ]);
    }

    /**
     * Get data of a Notice
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notice=Notice::find($id);

        return response()->json($notice, 200) ;
    }

    /**
     * create a new Notice
     * @param Request $request
     *
     * @return Notice
     */
    public function store(Request $request)
    {
        $notice = Notice::create($request->all());

        return response()->json($notice, 200);
    }

    /**
     * update a  Notice
     *@param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $parameters = $request->only('name, textNotice');

        $notice = Notice::find($id);

        if (!$notice) {
            return response()->json("This notice is not exist", '401');
        }

        $notice->name = $parameters['name'];
        $notice->textNotice = $parameters['textNotice'];

        $notice->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete a Notice
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $notice = Notice::find($id);

        if (!$notice) {
            return response()->json("This notice is not exist", '401');
        }

        Notice::destroy($id);

        return  response()->json('deleted', 200);
    }

    /**
     * Create a Gallery for the Notice
     *
     * @param $id
     * @param Request request
     * @return void
     */
    public function createGallery(Request $request, $id)
    {
        $image=new NoticeImage();
        $Noticeimage=$request->file('img');
        $route = public_path().'/galery/';
        $imageName=$Noticeimage->getClientOriginalName();
        $Noticeimage->move($route, $imageName);
        $image->image=$imageName;
        $image->idNotice=$id;
        $image->save();
    }
}
