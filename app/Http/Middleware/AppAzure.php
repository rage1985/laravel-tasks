<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use RootInc\LaravelAzureMiddleware\Azure as Azure;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

use Auth;

use App\Models\User;

class AppAzure extends Azure
{
    protected function success(Request $request, $access_token, $refresh_token, $profile)
    {
        $graph = new Graph();
        $graph->setAccessToken($access_token);

        $graph_user = $graph->createRequest("GET", "/me")
            ->setReturnType(Model\User::class)
            ->execute();

        $email = strtolower($graph_user->getUserPrincipalName());
        $partner = Partner::where('email', $mail);
        $user = User::updateOrCreate(['email' => $email], [
            'name' => $graph_user->getGivenName() . ' ' . $graph_user->getSurname(),
            'partner_id' => $partner->partner_id,
        ]);

        Auth::login($user, true);



        return parent::success($request, $access_token, $refresh_token, $profile);
        #return redirect()->route('dashboard', [$request, $access_token, $refresh_token, $profile]);
    }
}
