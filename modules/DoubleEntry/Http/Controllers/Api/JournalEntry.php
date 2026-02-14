<?php

namespace Modules\DoubleEntry\Http\Controllers\Api;

use App\Abstracts\Http\ApiController;
use Modules\DoubleEntry\Models\Journal;
use Modules\DoubleEntry\Jobs\Journal\CreateJournalEntry;
use Modules\DoubleEntry\Jobs\Journal\DeleteJournalEntry;
use Modules\DoubleEntry\Jobs\Journal\UpdateJournalEntry;
use Modules\DoubleEntry\Http\Requests\Journal as Request;
use Modules\DoubleEntry\Http\Resources\JournalEntry as Resource;

class JournalEntry extends ApiController
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-double-entry-journal-entry')->only('create', 'store');
        $this->middleware('permission:read-double-entry-journal-entry')->only('index', 'show');
        $this->middleware('permission:update-double-entry-journal-entry')->only('enable', 'disable');
        $this->middleware('permission:delete-double-entry-journal-entry')->only('destroy');
        $this->middleware('permission:read-double-entry-journal-entry')->only('edit');
        $this->middleware('permission:update-double-entry-journal-entry')->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $journals = Journal::collect();

        return Resource::collection($journals);
    }

    /**
     * Display the specified resource.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $journal = Journal::find($id);

        if (! $journal instanceof Journal) {
            return $this->errorInternal('No query results for model [' . Journal::class . '] ' . $id);
        }

        return new Resource($journal);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $journal = $this->dispatch(new CreateJournalEntry($request));
            
        return $this->created(route('api.journal-entry.show', $journal->id), new Resource($journal));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $journal = Journal::find($id);

        $journal = $this->dispatch(new UpdateJournalEntry($journal, $request));

        return new Resource($journal->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $journal = Journal::find($id);

        try {
            $this->dispatch(new DeleteJournalEntry($journal));

            return $this->noContent();
        } catch(\Exception $e) {
            $this->errorUnauthorized($e->getMessage());
        }
    }
}
