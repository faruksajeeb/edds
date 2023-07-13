<?php

namespace App\Lib;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Exception;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Mail;
use Intervention\Image\Facades\Image;
use App\Traits\Setting as S;

class Webspice
{
	use S;
	# Poperties
	protected $user;
	public $emailFrom = 'dev4nns@gmail.com';
	public $adminEmail = 'ofsajeeb@gmail.com';
	public $emailFromName = "EDDS ADMIN";

	public static function appUrl()
	{
		return S::appUrl();
	}
	public function settings()
	{
	}

	static function test()
	{

		return 'Hello! Im from webspice.';
	}

	static function log(string $table, $id, string $action)
	{
		$currentTime = Carbon::now("Asia/Dhaka");
		$userId = Auth::user()->id;
		$userName = Auth::user()->name;
		Log::channel('customlog')->info($currentTime . ' | USER ID:' . $userId . ' | USER NAME:' . $userName . ' | TABLE:' . $table . ' | ROW ID:' . $id . ' | ' . $action);
	}
	public function userVerify()
	{
		$this->user = Auth::guard('web')->user();
		if (!$this->user || is_null($this->user)) {
			redirect('login');
		}
	}
	public function permissionVerify(string $permissionName)
	{
		$this->userVerify();
		if (is_null($this->user)) {
			abort(403, 'SORRY! unauthenticated access!');
		}
		if (!$this->user->can($permissionName)) {
			abort(403, 'SORRY! unauthorized access!');
		}
	}
	public function message(string $type, string $message = null)
	{
		switch ($type) {
			case 'insert_success':
				Session::flash('success', 'Data Inserted Successfully.');
				break;
			case 'update_success':
				Session::flash('success', 'Data Updated Successfully.');
				break;
			case 'delete_success':
				Session::flash('success', 'Data Deleted Successfully.');
				break;
			case 'restore_success':
				Session::flash('success', 'Data Restored Successfully.');
				break;
			case 'force_delete_success':
				Session::flash('success', 'Data force deleted successfully.');
				break;
			case 'verify_success':
				Session::flash('success', 'Data verified successfully.');
				break;
			case 'error':
				Session::flash('error', 'Operation Failed. ' . $message);
				break;
			default:
				Session::flash('error', 'We could not execute your request. Something went wrong.');
		}
	}

	public function insertOrFail(string $type, string $message = null)
	{
		Session::flash($type, $type == 'success' ? 'Data Inserted Successfully. ' . $message : 'SORRY! Data not inserted. ' . $message);
	}
	public function updateOrFail(string $type, string $message = null)
	{
		Session::flash($type, $type == 'success' ? 'Data Updated Successfully. ' . $message : 'SORRY! Data not updated. ' . $message);
	}
	public function deleteOrFail(string $type, string $message = null)
	{
		Session::flash($type, $type == 'success' ? 'Data Deleted Successfully. ' . $message : 'SORRY! Data not deleted. ' . $message);
	}

	public function encryptDecrypt(string $type, $value)
	{
		if ($type == 'decrypt') {
			$value = Crypt::decryptString($value);
		} elseif ($type == 'encrypt') {
			$value = Crypt::encryptString($value);
		}
		return $value;
	}

	static function textStatus($status)
	{
		$text = null;
		switch ($status) {
			case 'pending':
				$text = '<span class="badge bg-secondary">Pending</span>';
				break;
			case 'ordered':
				$text = '<span class="badge bg-primary">Ordered</span>';
				break;
			case 'processing':
				$text = '<span class="badge bg-warning">Processing</span>';
				break;
			case 'approved':
				$text = '<span class="badge bg-success">Approved</span>';
				break;
			case 'delivered':
				$text = '<span class="badge bg-success">Delivered</span>';
				break;
			case 'canceled':
				$text = '<span class="badge bg-danger">Canceled</span>';
				break;
			case 'declined':
				$text = '<span class="badge bg-danger">Declined</span>';
				break;
			default:
				$text = '<span class="badge bg-default">Unknown</span>';
				break;
		}
		return $text;
	}

	static function status($status)
	{
		/*
		# Status
		1=Pending,2=Approved,3=Resolved,4=Forwarded,5=Deployed,6=New,7=Active,8=Initiated,9=On Progress,10=Delivered,
		11=Locked,12=Returned,13=Sold,14=Paid,20=Settled,21=Replaced,22=Completed,23=Confirmed,24=Honored,-24=Dishonored,25=Accepted
		-1=Deleted,-2=Declined,-3=Canceled,-5=Taking out,-6=Renewed,-7=Inactive;
		*/
		$text = null;
		switch ($status) {
			case 0:
				$text = '<span class="badge bg-info">Pending</span>';
				break;
			case 1:
				$text = '<span class="badge bg-info">Active</span>';
				break;
			case 2:
				$text = '<span class="badge bg-success">Verified</span>';
				break;
			case 3:
				$text = '<span class="badge bg-success">Resolved</span>';
				break;
			case 4:
				$text = '<span class="badge bg-info">Forwarded</span>';
				break;
			case 5:
				$text = '<span class="badge bg-success">Deployed</span>';
				break;
			case 6:
				$text = '<span class="badge bg-info">New</span>';
				break;
				// case 7:
				// 	$text = '<span class="badge bg-success">Active</span>';
				// 	break;
			case 8:
				$text = '<span class="badge bg-info">Initiated</span>';
				break;
			case 9:
				$text = '<span class="badge bg-warning">On Progress</span>';
				break;
			case 10:
				$text = '<span class="badge bg-success">Delivered</span>';
				break;
			case 11:
				$text = '<span class="badge bg-info">Locked</span>';
				break;
			case 12:
				$text = '<span class="badge bg-success">Returned</span>';
				break;
			case 13:
				$text = '<span class="badge bg-danger">Sold</span>';
				break;
			case 14:
				$text = '<span class="badge bg-success">Paid</span>';
				break;
			case 15:
				$text = '<span class="badge bg-warning">Testing</span>';
				break;
			case 16:
				$text = '<span class="badge bg-success">Verified</span>';
				break;
			case 20:
				$text = '<span class="badge bg-success">Settled</span>';
				break;
			case 21:
				$text = '<span class="badge bg-warning">Replaced</span>';
				break;
			case 22:
				$text = '<span class="badge bg-success">Completed</span>';
				break;
			case 23:
				$text = '<span class="badge bg-success">Confirmed</span>';
				break;
			case 24:
				$text = '<span class="badge bg-success">Honored</span>';
				break;
			case 25:
				$text = '<span class="badge bg-danger">Defaulter</span>';
				break;
			case 26:
				$text = '<span class="badge bg-success">Not Defaulter</span>';
				break;
			case 28:
				$text = '<span class="badge bg-success">Allowed</span>';
				break;
			case 29:
				$text = '<span class="badge bg-success">Accepted</span>';
				break;
			case 30:
				$text = '<span class="badge bg-success">Taken</span>';
				break;
			case 31:
				$text = '<span class="badge bg-success">Partial Paid</span>';
				break;
			case 32:
				$text = '<span class="badge bg-success">Reviewed</span>';
				break;
			case 33:
				$text = '<span class="badge bg-success">Processed</span>';
				break;
			case 34:
				$text = '<span class="badge bg-success">Acknowledged</span>';
				break;

			case -24:
				$text = '<span class="badge bg-danger">Dishonored</span>';
				break;

			case -1:
				$text = '<span class="badge bg-danger">Inactive</span>';
				break;
			case -2:
				$text = '<span class="badge bg-danger">Declined</span>';
				break;
			case -3:
				$text = '<span class="badge bg-danger">Canceled</span>';
				break;
			case -5:
				$text = '<span class="badge bg-danger">Taking out</span>';
				break;
			case -6:
				$text = '<span class="badge bg-danger">Renewed</span>';
				break;
				// case -7:
				// 	$text = '<span class="badge bg-danger">Inactive</span>';
				// 	break;
			default:
				$text = '<span class="badge bg-default">Unknown</span>';
				break;
		}

		return $text;
	}

	public function activeInactive(Request $request)
	{
		try {
			$id = $this->encryptDecrypt('decrypt', $request->id);
			$status = '';
			$text = '';
			if ($request->status == 1) {
				$status = -1;
				$text = 'inactivated';
			} elseif ($request->status == -1) {
				$status = 1;
				$text = 'activated';
			}
			$effectedRow = DB::table($request->table)->where('id', $id)->first();
			DB::table($request->table)->where('id', $id)->update([
				'status' => $status,
				'updated_by' => $this->getUserId(),
				'updated_at' =>  $this->now("datetime24")
			]);
			$queryStatus = [
				'status' => 'success',
				'changed_value' => $status,
				'message' => "Status $text successfully."
			];
			if ($queryStatus['status'] == 'success') {
				self::versionUpdate();
				# log
				$this->log($request->table, $id, $text);
				$this->forgetCache($request->table);
				if ($request->table == 'options') {
					$this->forgetCache('active-' . $effectedRow->option_group_name . '-options');
					$this->forgetCache('inactive-' . $effectedRow->option_group_name . '-options');
				} else {
					$this->forgetCache('active-' . $request->table);
					$this->forgetCache('inactive-' . $request->table);
				}

				# Update chace 
				//  $cache = Redis::get($request->table);
				// if (!isset($cache)) {
				// 	$cache = DB::table($request->table)->get();
				// 	Redis::set($request->table, json_encode($cache));
				// 	$cache = Redis::get($request->table);
				// }
				// $cache = Cache::get($request->table);

				// if (!isset($cache)) {
				// 	$cache = DB::table($request->table)->get();
				// 	Cache::set($request->table, json_encode($cache));
				// 	$cache = Cache::get($request->table);
				// }

				// $cacheData = collect(json_decode($cache));
				// $data = $cacheData->where('id', $id)->first();
				// $data->status = $status;
				// $data->updated_by = $this->getUserId();
				// $data->updated_at = $this->now("datetime24");
				// $index = $cacheData->search($data);
				// $cacheData[$index] = $data;
				// Redis::set($request->table, json_encode($cacheData));
				// Cache::set($request->table, json_encode($cacheData));
				//dd(Cache::get($request->table));
			}
		} catch (Exception $e) {
			$queryStatus = [
				'status' => 'not_success',
				'message' => 'SORRY! Status has not changed.' . $e->getMessage()
			];
		}

		return response()->json($queryStatus);
	}

	public function hasCache($cacheName)
	{
		return Cache::has($cacheName);
	}

	public function createCache($cacheName, $data)
	{
		Cache::forever($cacheName, $data);
	}

	public function getCache($cacheName)
	{
		return Cache::get($cacheName);
	}
	# Remove Cache	
	public static function forgetCache($cacheName)
	{
		Cache::forget($cacheName);
		Cache::forget('active-' . $cacheName);
		Cache::forget('inactive-' . $cacheName);
	}

	function static_exchange_status($status)
	{
		# 1=Pending, 2=Approved, 3=Resolved, 4=Forwarded, 5=Deployed, 6=New, 7=Active, 8=Initiated, 9=On Progress, 10=Delivered, -2=Declined, -3=Canceled, -5=Taking out, -6=Renewed/Replaced, -7=Inactive
		$text = null;
		switch ($status) {
			case 1:
				$text = '<span class="label label-info">Pending/Active</span>';
				break;
			case 2:
				$text = '<span class="label label-success">Approved</span>';
				break;
			case 3:
				$text = '<span class="label label-success">Resolved</span>';
				break;
			case 4:
				$text = '<span class="label label-purple">Forwarded</span>';
				break;
			case 5:
				$text = '<span class="label label-success">Deployed</span>';
				break;
			case 6:
				$text = '<span class="label label-info">New</span>';
				break;
			case 7:
				$text = '<span class="label label-info">Active</span>';
				break;
			case 8:
				$text = '<span class="label label-danger">Reported</span>';
				break;
			case 9:
				$text = '<span class="label label-info">On Progress</span>';
				break;
			case 10:
				$text = '<span class="label label-success">Delivered</span>';
				break;
			case 11:
				$text = '<span class="label label-warning">On Investigation</span>';
				break;
			case 12:
				$text = '<span class="label label-success">Closed</span>';
				break;
			case 13:
				$text = '<span class="label label-info">Feedback Given</span>';
				break;
			case 14:
				$text = '<span class="label label-primary">Inv Complete</span>';
				break;
			case 15:
				$text = '<span class="label label-success">Verified</span>';
				break;
			case 16:
				$text = '<span class="label label-success">Sent</span>';
				break;
			case 17:
				$text = '<span class="label label-success">Received</span>';
				break;
			case 18:
				$text = '<span class="label label-success">Returned</span>';
				break;
			case 19:
				$text = '<span class="label label-success">Confirmed</span>';
				break;
			case 20:
				$text = '<span class="label label-purple">Forwarded to Maintenance</span>';
				break;

			case 21:
				$text = '<span class="label label-success">Placed</span>';
				break;
			case 22:
				$text = '<span class="label label-primary">Served</span>';
				break;
			case 23:
				$text = '<span class="label label-primary">Forwarded</span>';
				break;

			case 24:
				$text = '<span class="label label-success">Started</span>';
				break;
			case 25:
				$text = '<span class="label label-warning">Initiated</span>';
				break;
			case 26:
				$text = '<span class="label label-success">Completed</span>';
				break;
			case 27:
				$text = '<span class="label label-success">Sold</span>';
				break;
			case 28:
				$text = '<span class="label label-success">Assigned</span>';
				break;

				# Security personnel requisition additional steps
			case 29:
				$text = '<span class="label label-warning">Forwarded to Admin</span>';
				break;
			case 30:
				$text = '<span class="label label-success">Re-assigned Vendor</span>';
				break;
			case 31:
				$text = '<span class="label label-success">Proposal submitted by Vendor</span>';
				break;
			case 32:
				$text = '<span class="label label-success">Accepted & Deployed</span>';
				break;

			case 33:
				$text = '<span class="label label-success">Accepted</span>';
				break;

			case 34:
				$text = '<span class="label label-success">Allowed</span>';
				break;

				#Level of Authority(LOA)
			case 101:
				$text = '<span class="label label-success">LOA One</span>';
				break;
			case 102:
				$text = '<span class="label label-success">LOA Two</span>';
				break;
			case 103:
				$text = '<span class="label label-success">LOA Three</span>';
				break;
			case 104:
				$text = '<span class="label label-success">LOA Four</span>';
				break;
			case 105:
				$text = '<span class="label label-success">LOA Five</span>';
				break;
			case -1:
				$text = '<span class="label label-danger">Inactive</span>';
				break;
			case -2:
				$text = '<span class="label label-danger">Declined</span>';
				break;
			case -3:
				$text = '<span class="label label-danger">Canceled</span>';
				break;
			case -5:
				$text = '<span class="label label-warning">Taking out</span>';
				break;
			case -6:
				$text = '<span class="label label-info">Renewed/Replaced</span>';
				break;
			case -7:
				$text = '<span class="label label-danger">Inactive</span>';
				break;
			case -8:
				$text = '<span class="label label-warning">Withdrawn</span>';
				break;
			case -24:
				$text = '<span class="label label-danger">Deleted</span>';
				break;
			default:
				$text = '<span class="label label-default">Unknown</span>';
				break;
		}

		return $text;
	}

	static function sanitizeFileName($fileName)
	{

		$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$file_name_str = pathinfo($fileName, PATHINFO_FILENAME);

		// Replaces all spaces with hyphens. 
		$file_name_str = str_replace(' ', '-', $file_name_str);
		// Removes special chars. 
		$file_name_str = preg_replace('/[^A-Za-z0-9\-\_]/', '', $file_name_str);
		// Replaces multiple hyphens with single one. 
		$file_name_str = preg_replace('/-+/', '-', $file_name_str);

		$clean_file_name = $file_name_str . '.' . $file_ext;
		return $clean_file_name;
	}

	static function now($param = null)
	{
		//return self::testStaticMethod();
		// date_default_timezone_set('Asia/Dhaka');
		$date =  Carbon::now('Asia/Dhaka');
		switch ($param) {
			case 'time':
				return $date->format('h:i:s');
				break;

			case 'timeampm':
				return $date->format('h:i:s A');
				break;

			case 'time24':
				return $date->format('H:i:s');
				break;

			case 'date':
				return $date->format('Y-m-d');
				break;

			case 'datetime24':
				return $date->format('Y-m-d H:i:s');
				break;

			default:
				return $date->format('Y-m-d h:i:s');
				break;
		}
	}

	public static function testStaticMethod()
	{
		return "Hello, I am static";
	}

	public function getUserId(): int
	{
		return Auth::user()->id;
	}

	public function sendEmail(string $to, string $cc = null, string $subject, array $data = null, string $template)
	{
		# Send Mail
		$to = 'ofsajeeb@gmail.com'; # please comment this line on production
		// Mail::send($template, $data, function ($email) use($to,$subject){
		//     $email->to($to, 'Concern');
		// 	$email->subject($subject);
		//     $email->from($this->emailFrom, $this->emailFromName);
		// });
	}

	function date_excel_to_real($dateValue = 0, $format = "d-m-Y")
	{
		# dd(strlen(trim($dateValue)));
		if (strlen(trim($dateValue)) == 5) {
			$unix_val = ($dateValue - 25569) * 86400;
			$date = gmdate($format, $unix_val);
		} else {
			$date = date($format, strtotime($dateValue));
		}

		if (date('Y-m-d', strtotime($date)) == '1970-01-01') {
			return 0;
		}

		return $date;
	}


	function getGeoData($address, $component)
	{
		$cityCoordinates = array();
		$cityCoordinates['Dhaka'] = json_decode('{"results":[{"address_components":[{"long_name":"Dhaka","short_name":"Dhaka","types":["locality","political"]},{"long_name":"Dhaka District","short_name":"Dhaka District","types":["administrative_area_level_2","political"]},{"long_name":"Dhaka Division","short_name":"Dhaka Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Dhaka, Bangladesh","geometry":{"bounds":{"northeast":{"lat":23.9000025,"lng":90.5090166},"southwest":{"lat":23.6612704,"lng":90.3295468}},"location":{"lat":23.810332,"lng":90.4125181},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":23.9000025,"lng":90.5090166},"southwest":{"lat":23.6612704,"lng":90.3295468}}},"place_id":"ChIJgWsCh7C4VTcRwgRZ3btjpY8","types":["locality","political"]}],"status":"OK"}');
		$cityCoordinates['Chattogram'] = json_decode('{"results":[{"address_components":[{"long_name":"Chattogram","short_name":"Chattogram","types":["locality","political"]},{"long_name":"Chittagong District","short_name":"Chittagong District","types":["administrative_area_level_2","political"]},{"long_name":"Chittagong Division","short_name":"Chittagong Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Chattogram, Bangladesh","geometry":{"bounds":{"northeast":{"lat":22.4306091,"lng":91.89192229999999},"southwest":{"lat":22.2212596,"lng":91.7478132}},"location":{"lat":22.356851,"lng":91.7831819},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":22.4306091,"lng":91.89192229999999},"southwest":{"lat":22.2212596,"lng":91.7478132}}},"place_id":"ChIJ09-VQKbYrDAR2QVpy1vMFVA","types":["locality","political"]}],"status":"OK"}');
		$cityCoordinates['Barishal'] = json_decode('{"results":[{"address_components":[{"long_name":"Barishal","short_name":"Barishal","types":["locality","political"]},{"long_name":"Barisal District","short_name":"Barisal District","types":["administrative_area_level_2","political"]},{"long_name":"Barisal Division","short_name":"Barisal Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Barishal, Bangladesh","geometry":{"bounds":{"northeast":{"lat":22.7438022,"lng":90.3900342},"southwest":{"lat":22.646964,"lng":90.3175744}},"location":{"lat":22.7010021,"lng":90.35345110000002},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":22.7438022,"lng":90.3900342},"southwest":{"lat":22.646964,"lng":90.3175744}}},"partial_match":true,"place_id":"ChIJh-Ts-wc0VTcRSkHUmZWbBl0","types":["locality","political"]}],"status":"OK"}');
		$cityCoordinates['Khulna'] = json_decode('{"results":[{"address_components":[{"long_name":"Khulna","short_name":"Khulna","types":["locality","political"]},{"long_name":"Khulna District","short_name":"Khulna District","types":["administrative_area_level_2","political"]},{"long_name":"Khulna Division","short_name":"Khulna Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Khulna, Bangladesh","geometry":{"bounds":{"northeast":{"lat":22.933575,"lng":89.58234780000001},"southwest":{"lat":22.7570288,"lng":89.48265560000002}},"location":{"lat":22.845641,"lng":89.54032789999999},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":22.933575,"lng":89.58234780000001},"southwest":{"lat":22.7570288,"lng":89.48265560000002}}},"place_id":"ChIJLxVHy3GQ_zkRUolxkCIhS_A","types":["locality","political"]}],"status":"OK"}');
		$cityCoordinates['Mymensingh'] = json_decode('{"results":[{"address_components":[{"long_name":"Mymensingh","short_name":"Mymensingh","types":["locality","political"]},{"long_name":"Mymensingh District","short_name":"Mymensingh District","types":["administrative_area_level_2","political"]},{"long_name":"Mymensingh Division","short_name":"Mymensingh Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Mymensingh, Bangladesh","geometry":{"bounds":{"northeast":{"lat":24.7836463,"lng":90.4485512},"southwest":{"lat":24.7142056,"lng":90.3444408}},"location":{"lat":24.7471492,"lng":90.4202734},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":24.7836463,"lng":90.4485512},"southwest":{"lat":24.7142056,"lng":90.3444408}}},"place_id":"ChIJWZutBxBPVjcRbC3jYLCcpXk","types":["locality","political"]}],"status":"OK"}');
		$cityCoordinates['Rajshahi'] = json_decode('{"results":[{"address_components":[{"long_name":"Rajshahi","short_name":"Rajshahi","types":["locality","political"]},{"long_name":"Rajshahi District","short_name":"Rajshahi District","types":["administrative_area_level_2","political"]},{"long_name":"Rajshahi Division","short_name":"Rajshahi Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Rajshahi, Bangladesh","geometry":{"bounds":{"northeast":{"lat":24.4110607,"lng":88.6670065},"southwest":{"lat":24.3492474,"lng":88.5450254}},"location":{"lat":24.3745146,"lng":88.60416599999999},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":24.4110607,"lng":88.6670065},"southwest":{"lat":24.3492474,"lng":88.5450254}}},"place_id":"ChIJMdA4aqnv-zkREPTWDpU6-RA","types":["locality","political"]}],"status":"OK"}');
		$cityCoordinates['Rangpur'] = json_decode('{"results":[{"address_components":[{"long_name":"Rangpur","short_name":"Rangpur","types":["locality","political"]},{"long_name":"Rangpur District","short_name":"Rangpur District","types":["administrative_area_level_2","political"]},{"long_name":"Rangpur Division","short_name":"Rangpur Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Rangpur, Bangladesh","geometry":{"bounds":{"northeast":{"lat":25.7894586,"lng":89.3148492},"southwest":{"lat":25.7102183,"lng":89.2092418}},"location":{"lat":25.7438916,"lng":89.275227},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":25.7894586,"lng":89.3148492},"southwest":{"lat":25.7102183,"lng":89.2092418}}},"place_id":"ChIJmwGm_OYt4zkRyBj4h-aWpJ8","types":["locality","political"]}],"status":"OK"}');
		$cityCoordinates['Sylhet'] = json_decode('{"results":[{"address_components":[{"long_name":"Sylhet","short_name":"Sylhet","types":["locality","political"]},{"long_name":"Sylhet District","short_name":"Sylhet District","types":["administrative_area_level_2","political"]},{"long_name":"Sylhet Division","short_name":"Sylhet Division","types":["administrative_area_level_1","political"]},{"long_name":"Bangladesh","short_name":"BD","types":["country","political"]}],"formatted_address":"Sylhet, Bangladesh","geometry":{"bounds":{"northeast":{"lat":24.9378139,"lng":91.9106771},"southwest":{"lat":24.8617132,"lng":91.8112867}},"location":{"lat":24.8949294,"lng":91.8687063},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":24.9378139,"lng":91.9106771},"southwest":{"lat":24.8617132,"lng":91.8112867}}},"place_id":"ChIJnzJw0tNUUDcRgnP2MTT5jvU","types":["locality","political"]}],"status":"OK"}');

		if (!isset($cityCoordinates[$address])) {
			return 'address-not-found';
		}
		switch ($component) {
			case 'location':
				if (isset($cityCoordinates[$address]->results[0]->geometry->location)) {
					return $cityCoordinates[$address]->results[0]->geometry->location;
				}
				break;
		}

		return false;
	}



	static function getColorCodeForMapArea(array $dbResultArray, $category, $areaName)
	{
		// dd($category);
		# static value
		if (Cache::has('basic_settings')) {
			# get from file cache
			$basicSettings = Cache::get('basic_settings');
		} else {
			# get from database
			$basicSettings = DB::table('basic_settings')->first();
			Cache::put('basic_settings', $basicSettings);
		}
		$thresholdMin = $basicSettings->threshold_min;
		$thresholdMid = $basicSettings->threshold_mid;
		$thresholdMax = $basicSettings->threshold_max;
		$maxColor = '#de2d26';
		$midColor = '#fb6a4a';
		$minColor = '#F8AFA6';
		$defaultColor = '#F9F1F0';
		$value = 0;
		foreach ($dbResultArray as $k => $v) {
			if ($category == 'Poultry') {
				$value = $v->TOTAL_POULTRY;
			} elseif ($category == 'Wild Bird') {
				$value = $v->TOTAL_WILD_BIRD;
			} elseif ($category == 'LBM Worker') {
				$value = $v->TOTAL_LBM_WORKER;
			}

			if (strtolower($v->district) != strtolower($areaName)) {
				continue;
			}

			if ($value >= $thresholdMax) {
				return $maxColor;
			} elseif ($value >= $thresholdMid) {
				return $midColor;
			} elseif ($value >= $thresholdMin) {
				return $minColor;
			}
		}

		return $defaultColor; # default
	}

	function convertToBanglaNumber($number)
	{
		$englishNumbers = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
		$banglaNumbers = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');

		$converted = str_replace($englishNumbers, $banglaNumbers, $number);
		return $converted;
	}

	function convertToBanglaDay($day)
	{
		if ($day) {
			$englishDays = array('Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
			$banglaDays = array('শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার');

			$converted = str_replace($englishDays, $banglaDays, $day);
			return $converted;
		}
	}

	function convertToBanglaDayShort($day)
	{
		if ($day) {
			$englishDays = array('Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri');
			$banglaDays = array('শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহঃ', 'শুক্র');

			$converted = str_replace($englishDays, $banglaDays, $day);
			return $converted;
		}
	}

	function convertToBanglaMonth($month)
	{
		if ($month) {
			$englishMonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$banglaMonths = array('জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর');

			$converted = str_replace($englishMonths, $banglaMonths, $month);
			return $converted;
		}
	}

	function convertToBanglaMonthShort($month)
	{
		if ($month) {
			$englishMonths = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
			$banglaMonths = array('জানু', 'ফেব্রু', 'মার্চ', 'এপ্রি', 'মে', 'জুন', 'জুলা', 'আগ', 'সেপ্টে', 'অক্টো', 'নভে', 'ডিসে');

			$converted = str_replace($englishMonths, $banglaMonths, $month);
			return $converted;
		}
	}

	function convertToBanglaDivision($division)
	{
		if ($division) {
			$englishDivisions = array('Dhaka', "Chittagong", 'Barishal', 'Khulna', 'Mymensingh', 'Rajshahi', 'Rangpur', 'Sylhet');
			$banglaDivisions = array('ঢাকা', "চট্টগ্রাম", 'বরিশাল', 'খুলনা', 'ময়মনসিংহ', 'রাজশাহী', 'রংপুর', 'সিলেট');

			$converted = str_replace($englishDivisions, $banglaDivisions, $division);
			return $converted;
		}
	}

	function convertToBangla($value)
	{
		$englishValues = array(
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
			'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
			'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri',
			'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
			'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
			'Dhaka', "Chattogram", 'Barishal', 'Khulna', 'Mymensingh', 'Rajshahi', 'Rangpur', 'Sylhet'
		);
		$banglaValues = array(
			'১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০',
			'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার',
			'শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহঃ', 'শুক্র',
			'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর',
			'জানু', 'ফেব্রু', 'মার্চ', 'এপ্রি', 'মে', 'জুন', 'জুলা', 'আগ', 'সেপ্টে', 'অক্টো', 'নভে', 'ডিসে',
			'ঢাকা', "চট্টগ্রাম", 'বরিশাল', 'খুলনা', 'ময়মনসিংহ', 'রাজশাহী', 'রংপুর', 'সিলেট'
		);
		$converted = str_replace($englishValues, $banglaValues, $value);
		return $converted;
	}


	public static function imageShow($filename)
	{
		$path = public_path('images/' . $filename);
		$image = Image::make($path);

		// Resize the image to a lower resolution
		$image->resize(320, 240); // Adjust the dimensions as needed

		// Set the response header and output the image
		return $image->response();
	}

	public static function versionUpdate()
	{
		DB::update('UPDATE tbl_data_version SET version =version+.1 WHERE id = ?', [1]);
	}

	public function changeOrder(Request $request)
	{
		// return $request->all();
		// get the list of items id separated by cama (,)
		$table_name = $request->table_name;
		$list_order = $request->list_order;

		// convert the string list to an array   
		try{  
			$list = explode(',', $list_order);
			self::updateTableOrder($list, $table_name);
			$queryStatus = [
				'status' => 'success',
				'message' => "Order has been changed successfully."
			];
			self::versionUpdate();
		} catch (Exception $e) {
			$queryStatus = [
				'status' => 'not_success',
				'message' => 'SORRY! Order has not changed.' . $e->getMessage()
			];
		}
		return response()->json($queryStatus);
	}

	public static function updateTableOrder($list, $tableName)
	{
		$i = 1;
		foreach ($list as $id) {
			$result = DB::update("UPDATE $tableName SET sl_order =$i WHERE id = ?", [$id]);
			$i++;
			self::log($tableName, $id, 'ORDER_UPDATED');
		}
		return $result;
	}

	public static function isValidCoordinates($latitude, $longitude) {
		// Check if the values are numeric
		if (!is_numeric($latitude) || !is_numeric($longitude)) {
			return false;
		}
		
		// Check if the latitude is within the valid range (-90 to 90)
		if ($latitude < -90 || $latitude > 90) {
			return false;
		}
		
		// Check if the longitude is within the valid range (-180 to 180)
		if ($longitude < -180 || $longitude > 180) {
			return false;
		}
		
		// All checks passed, the coordinates are valid
		return true;
	}	
}
