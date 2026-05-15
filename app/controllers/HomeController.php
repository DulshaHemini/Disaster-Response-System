<?php
require_once APP_PATH . '/models/DashboardModel.php';

class HomeController
{
    public function index(): void
    {
        $model = new DashboardModel();
        
        extract([
            'kpis'               => $model->getKpis(),
            'alerts'             => $model->getAlerts(),
            'needs'              => $model->getNeeds(),
            'readiness'          => $model->getReadiness(),
            'disasterTypes'      => $model->getDisasterTypes(),
            'resourceAllocation' => $model->getResourceAllocation(),
            'responseTimes'      => $model->getResponseTimes(),
            'heroStats'          => $model->getHeroStats(),
            'emergencyContacts'  => $model->getEmergencyContacts(),
        ]);

        require APP_PATH . '/views/home/index.php';
    }
}
