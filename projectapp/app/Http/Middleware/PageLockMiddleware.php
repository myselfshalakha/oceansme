<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserEvents;
use App\Models\EventAttending; 
use Auth;

class PageLockMiddleware
{
    public function handle(Request $request, Closure $next)
    {
		if($request->route('param')&& $request->route('param')=="search_applicant"){
			$id = $request->id;
				$page = UserEvents::find($id);
			if(!empty($page)){
				$date1 = date("Y-m-d h:i:s");
				if (!empty($page->lock_date)){
				$date2 = date("Y-m-d h:i:s",strtotime($page->lock_date));
				
				if (!empty($page->lock_date)&&($date1 < $date2) && $page->edited_by != Auth::user()->id) {
					$attending= EventAttending::where('uevent_id', $page->id)->first();
					if(isset($attending->status)&&$attending->status!=9){
						abort(403); // Or redirect to an error page
					}
				}
				}
				$lock_date = date("Y-m-d h:i:s", strtotime('+10 seconds', strtotime($date1)));
				
				$page->lock_date = $lock_date;
				$page->edited_by = Auth::user()->id;
				$page->save();
				
			}
		}
        return $next($request);
    }

   
}
