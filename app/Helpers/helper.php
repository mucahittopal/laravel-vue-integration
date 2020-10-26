<?php

if(!function_exists('upload_profile_photo'))
{
    /**
     * @param $image
     * @param $user
     * @return string
     */
    function upload_profile_photo($request_image, $user)
    {
        $upload_thumb = false;
        $upload_original = false;
        $image = \Intervention\Image\Facades\Image::make($request_image);
        $ext = $request_image->getClientOriginalExtension();
        $name = time().'.'.$ext;
        $filename = md5($user->id).'-'.time().'.'.$ext;
        $s3Path = '/profile-photos/original/'.$filename;
        $s3PathThumb = '/profile-photos/thumbnail/'.$filename;
        $localPath = 'storage/temp/'.$filename;
        $localPathThumb = 'storage/temp/thumbnail-'.$filename;
        $image->resize(250, null, function($c){
            $c->aspectRatio();
        });
        $image = $image->save($localPath, 60);
        if($image)
        {
            // user current profile photo
            $current_photo = $user->profile_photo;
            $thumbnail = \Intervention\Image\Facades\Image::make($localPath)
                ->resize(50, null, function ($con){
                    $con->aspectRatio();
                })->save($localPathThumb);
            $upload_original = \Illuminate\Support\Facades\Storage::disk('s3')
                ->put($s3Path, file_get_contents($localPath));
            $upload_thumb = \Illuminate\Support\Facades\Storage::disk('s3')
                ->put($s3PathThumb, file_get_contents($localPathThumb));
            // delete temp images
            unlink($localPath);
            unlink($localPathThumb);
            if($current_photo){
                if(\Illuminate\Support\Facades\Storage::disk('s3')
                    ->exists('/profile-photos/original/'.$current_photo)
                )
                {
                    \Illuminate\Support\Facades\Storage::disk('s3')
                        ->delete('/profile-photos/original/'.$current_photo);
                }
                if(\Illuminate\Support\Facades\Storage::disk('s3')
                    ->exists('/profile-photos/thumbnail/'.$current_photo)
                )
                {
                    \Illuminate\Support\Facades\Storage::disk('s3')
                        ->delete('/profile-photos/thumbnail/'.$current_photo);
                }
            }
        }

        return $upload_thumb && $upload_original ? $filename : '';
    }
}

if(!function_exists('get_profile_photo'))
{
    /**
     * @param $filename
     * @return array
     */
    function get_profile_photo($filename)
    {
        $resp = ['original' => '', 'thumbnail' => ''];
        // original
        $o = 'profile-photos/original/' . $filename;
        // thumbnail
        $t = 'profile-photos/thumbnail/' . $filename;

        if (\Illuminate\Support\Facades\Storage::disk('s3')->exists($o)) {
            $resp['original'] = \Illuminate\Support\Facades\Storage::disk('s3')->url($o);
        }

        if (\Illuminate\Support\Facades\Storage::disk('s3')->exists($t)) {
            $resp['thumbnail'] = \Illuminate\Support\Facades\Storage::disk('s3')->url($t);
        }

        return $resp;
    }
}

if(!function_exists('delete_image'))
{
    function delete_image($disk, $path)
    {
        $delete = false;
        if($path)
        {
            if(\Illuminate\Support\Facades\Storage::disk('s3')->exists($path)){
                $delete = \Illuminate\Support\Facades\Storage::disk($disk)->delete($path);
            }
        }
        return $delete;
    }
}


if(!function_exists('change_search_country'))
{
    function change_search_country($id)
    {
        $query = request()->query();
        $query['country_id'] = $id;
        // when country change the selected location depend on that country must be removed from query string
        unset($query['location_type']);
        unset($query['location']);
        $url = http_build_query($query);
        return $url;
    }
}


if(!function_exists('post_rating'))
{
    function post_rating($post)
    {
        $rate = 0;
        $friction = 0;
        $total_rate = 0;
        $count_reviews = 0;

        if(count($post->reviews)){

            foreach ($post->reviews as $review){
                $count_reviews++;
                $total_rate += $review->rate;
            }

            $rate = $total_rate / $count_reviews;
            $friction = $rate - floor($rate);
        }

        return [floor($rate), $friction];
    }
}
