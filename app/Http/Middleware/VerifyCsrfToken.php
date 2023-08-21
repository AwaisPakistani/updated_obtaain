<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "/admin/update-roles-permission",'/front/getting-issues-of-volume','/front/contributor-modal','/front/add-contributor','/front/paper1','/front/paper2','/front/paper3','/front/paper2/submit','/front/requestrolechange/reject','/front/requestrolechange/approve','/front/revisions','/front/add_edit/paper_views','/front/add_edit/paper_downloads'
    ];
}
