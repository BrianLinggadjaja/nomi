<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\RosterRetrievalContract;

class SPAController extends Controller
{
    public $rosterRetrievalContract;

    public function __construct(RosterRetrievalContract $rosterRetrievalContract)
    {
        $this->rosterRetrievalContract = $rosterRetrievalContract;
    }

    /**
     * Description: Gets the index page of the SPA.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //getStudentsFromRoster might need to be refactored, this call only grabs first class from current term
        $students = $this->rosterRetrievalContract->getStudentsFromRoster(env('CURRENT_TERM'), 0);

        return view('cards')->with('students', $students);
    }
}
