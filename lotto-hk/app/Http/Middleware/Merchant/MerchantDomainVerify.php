<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/3
 * Time: 17:16
 */
namespace App\Http\Middleware\Merchant;

use App\Http\Controllers\Mobiles\LDomainParse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MerchantDomainVerify
{
    use LDomainParse;

    public function handle(Request $request, Closure $next)
    {
        $login = session('_login_merchant');
        $rs = $this->parse($request);
        $domain_old = parse_url($request->fullUrl(), PHP_URL_HOST);
        $scheme = parse_url($request->fullUrl(), PHP_URL_SCHEME);
        $path = parse_url($request->fullUrl(), PHP_URL_PATH);
        if (isset($login) && isset($login->account)) {
            View::share('account', $login->account);
            if (isset($rs['merchant'])) {
                if ($login->account->id == $rs['merchant']->id) {
                    View::share('domain', $scheme . '://' . $login->account->domain . '.' . $rs['domain']);
                    return $next($request);
                }
            }

            $domain = $login->account->domain . '.' . $rs['domain'];
            if ($domain_old == $domain) {
                View::share('domain', $scheme . '://' . $domain);
                return $next($request);
            } else {
                return redirect($scheme . '://' . $login->account->domain . '.' . $rs['domain'] . $path);
            }
        } else {
            return $next($request);
        }
    }

}