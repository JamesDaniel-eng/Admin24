<?php

namespace Modules\CompositeItems\Jobs;

use App\Abstracts\Job;
use App\Interfaces\Job\HasOwner;
use App\Interfaces\Job\HasSource;
use App\Interfaces\Job\ShouldCreate;
use Modules\CompositeItems\Models\DocumentItem;

class CreateDocumentItem extends Job implements HasOwner, HasSource, ShouldCreate
{
    public function handle(): DocumentItem
    {
        \DB::transaction(function () {
            $this->model = DocumentItem::create($this->request->all());
        });

        return $this->model;
    }
}
