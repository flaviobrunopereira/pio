<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\IpUtils;
use Log;

class RedirectInvalidIPs
{
/**
* List of valid IPs.
*
* @var array
*/
//protected $ips = ['192.168.69.221',];

/**
* List of valid IP-ranges.
*
* @var array
*/

//protected $ipRanges = ['172.16.11.0/24',];

/**
* Handle an incoming request.
*
* @param  \Illuminate\Http\Request $request
* @param  \Closure $next
* @return mixed
*/
public function handle($request, Closure $next)
{

foreach ($request->getClientIps() as $ip) {
if (! $this->isValidIp($ip) && ! $this->isValidIpRange($ip)) {
    Log::info('Invalid access by:' . $ip);
return redirect( env('REDIRECT_TO'));
}
}
return $next($request);
}

/**
* Check if the given IP is valid.
*
* @param $ip
* @return bool
*/
protected function isValidIp($ip)
{
   $ips = array(env('IP_ADDRESS'));
return in_array($ip, $ips);
}

/**
* Check if the ip is in the given IP-range.
*
* @param $ip
* @return bool
*/
protected function isValidIpRange($ip)
{
    $ipRanges = env('IP_RANGE');
return IpUtils::checkIp($ip, $ipRanges);
}
}
