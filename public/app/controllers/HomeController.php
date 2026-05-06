<?php
require_once APP_PATH . '/models/DashboardModel.php';

/**
 * HomeController
 * Handles the main landing page.
 */
class HomeController
{
    private DashboardModel $model;

    public function __construct()
    {
        $this->model = new DashboardModel();
    }

    public function index(): void
    {
        // Gather all data from the model
        $data = [
            'kpis'               => $this->model->getKpis(),
            'alerts'             => $this->model->getAlerts(),
            'needs'              => $this->model->getNeeds(),
            'readiness'          => $this->model->getReadiness(),
            'disasterTypes'      => $this->model->getDisasterTypes(),
            'resourceAllocation' => $this->model->getResourceAllocation(),
            'responseTimes'      => $this->model->getResponseTimes(),
            'heroStats'          => $this->model->getHeroStats(),
            'emergencyContacts'  => $this->model->getEmergencyContacts(),
        ];

        // Pass data to the layout which wraps the view
        $this->render('home/index', $data);
    }

    /**
     * Renders a view inside the main layout.
     *
     * @param string $view  Relative path under app/views/ (without .php)
     * @param array  $data  Variables to extract into the view scope
     */
    private function render(string $view, array $data = []): void
    {
        // Make data keys available as variables in the view
        extract($data, EXTR_SKIP);

        $viewFile = APP_PATH . '/views/' . $view . '.php';

        // Capture the view output so the layout can embed it
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render the layout with $content injected
        require APP_PATH . '/views/layouts/main.php';
    }
}
