<?php

namespace Modules\Payroll\Listeners;

use Throwable;
use App\Traits\Jobs;
use App\Models\Common\Report;
use App\Models\Common\Widget;
use App\Jobs\Common\DeleteReport;
use App\Jobs\Common\DeleteWidget;
use App\Events\Module\Uninstalled as Event;

class FinishUninstallation
{
    use Jobs;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != 'payroll') {
            return;
        }

        $this->deleteReports($event->alias);
       // $this->deleteWidgets($event->alias);
    }

    /**
     * Delete reports.
     *
     * @param  string $alias
     * @return void
     */
    protected function deleteReports($alias)
    {
        // For module specific reports
        Report::alias($alias)
            ->get()
            ->each(function ($report) {
                try {
                    $this->dispatch(new DeleteReport($report));
                } catch (Throwable $e) {
                    report($e);
                }
            });

        // For chart of account based reports
        Report::where('settings', 'like', '%employee%')
            ->get()
            ->each(function ($report) {
                try {
                    $this->dispatch(new DeleteReport($report));
                } catch (Throwable $e) {
                    report($e);
                }
            });
    }

    /**
     * Delete widgets.
     *
     * @param  string $alias
     * @return void
     */
    protected function deleteWidgets($alias)
    {
        // For module specific widgets
        Widget::alias($alias)
            ->get()
            ->each(function ($widget) {
                try {
                    $this->dispatch(new DeleteWidget($widget));
                } catch (Throwable $e) {
                    report($e);
                }
            });

        // For chart of account based reports
        Widget::where('class', 'like', '%Payroll%')
            ->get()
            ->each(function ($report) {
                try {
                    $this->dispatch(new DeleteWidget($report));
                } catch (Throwable $e) {
                    report($e);
                }
            });
    }
}
