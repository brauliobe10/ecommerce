let dashboardChartsPromise = null;

function loadDashboardCharts() {
    if (!document.querySelector('[data-dashboard-chart]')) {
        return;
    }

    if (!dashboardChartsPromise) {
        dashboardChartsPromise = import('./dashboard-charts');
    }

    dashboardChartsPromise.then(({ initDashboardCharts }) => {
        initDashboardCharts();
    });
}

document.addEventListener('DOMContentLoaded', loadDashboardCharts);
document.addEventListener('livewire:navigated', loadDashboardCharts);

document.addEventListener('livewire:navigating', () => {
    if (!dashboardChartsPromise) {
        return;
    }

    dashboardChartsPromise.then(({ destroyDashboardCharts }) => {
        destroyDashboardCharts();
    });
});
