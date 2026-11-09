import {
    BarController,
    BarElement,
    CategoryScale,
    Chart,
    Filler,
    Legend,
    LineController,
    LineElement,
    LinearScale,
    PointElement,
    Tooltip,
} from 'chart.js';

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    Filler,
    Legend,
    LineController,
    LineElement,
    LinearScale,
    PointElement,
    Tooltip,
);

const charts = new Map();
let themeObserver = null;
let lastDarkMode = null;
let rebuildFrame = null;

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function cssVar(name, fallback) {
    const value = getComputedStyle(document.documentElement).getPropertyValue(name).trim();

    return value || fallback;
}

function getTheme() {
    return {
        accent: cssVar('--color-accent', '#ff4757'),
        accentStrong: cssVar('--color-accent-strong', '#e63946'),
        textPrimary: cssVar('--color-text-primary', '#0f172a'),
        textSecondary: cssVar('--color-text-secondary', '#475569'),
        textTertiary: cssVar('--color-text-tertiary', '#94a3b8'),
        border: cssVar('--color-border', '#e2e8f0'),
        surface: cssVar('--color-surface', '#ffffff'),
        isDark: document.documentElement.classList.contains('dark'),
    };
}

function withAlpha(color, alpha) {
    const hex = color.replace('#', '').trim();

    if (!/^[0-9a-f]{6}$/i.test(hex)) {
        return color;
    }

    const red = parseInt(hex.slice(0, 2), 16);
    const green = parseInt(hex.slice(2, 4), 16);
    const blue = parseInt(hex.slice(4, 6), 16);

    return `rgba(${red}, ${green}, ${blue}, ${alpha})`;
}

function formatCurrency(value) {
    return `$${new Intl.NumberFormat('es-MX', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(Number(value) || 0)}`;
}

function formatCompactCurrency(value) {
    const number = Number(value) || 0;

    if (Math.abs(number) >= 1000000) {
        return `$${(number / 1000000).toFixed(1).replace('.0', '')}M`;
    }

    if (Math.abs(number) >= 1000) {
        return `$${(number / 1000).toFixed(1).replace('.0', '')}K`;
    }

    return `$${number}`;
}

function formatNumber(value) {
    return new Intl.NumberFormat('es-MX').format(Number(value) || 0);
}

function baseTooltip(theme) {
    return {
        backgroundColor: theme.surface,
        titleColor: theme.textPrimary,
        bodyColor: theme.textSecondary,
        borderColor: theme.border,
        borderWidth: 1,
        padding: 12,
        cornerRadius: 10,
        displayColors: true,
        boxWidth: 8,
        boxHeight: 8,
        usePointStyle: true,
        titleFont: { weight: '600' },
        bodyFont: { weight: '500' },
    };
}

function areaGradient(context, color) {
    const { chart } = context;
    const { ctx, chartArea } = chart;

    if (!chartArea) {
        return withAlpha(color, 0.16);
    }

    const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
    gradient.addColorStop(0, withAlpha(color, 0.28));
    gradient.addColorStop(1, withAlpha(color, 0.01));

    return gradient;
}

function buildIngresosChart(canvas, data, theme) {
    return new Chart(canvas, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Periodo actual',
                    data: data.actual,
                    borderColor: theme.accent,
                    backgroundColor: (context) => areaGradient(context, theme.accent),
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: theme.accent,
                    pointHoverBorderColor: theme.surface,
                    pointHoverBorderWidth: 2,
                },
                {
                    label: 'Periodo anterior',
                    data: data.anterior,
                    borderColor: withAlpha(theme.textTertiary, 0.9),
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: theme.textTertiary,
                    pointHoverBorderColor: theme.surface,
                    pointHoverBorderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: prefersReducedMotion() ? false : { duration: 700, easing: 'easeOutQuart' },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...baseTooltip(theme),
                    callbacks: {
                        label: (context) => `${context.dataset.label}: ${formatCurrency(context.parsed.y)}`,
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: theme.textTertiary,
                        font: { size: 11, weight: '600' },
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: withAlpha(theme.border, 0.65) },
                    border: { display: false },
                    ticks: {
                        color: theme.textTertiary,
                        font: { size: 11 },
                        callback: (value) => formatCompactCurrency(value),
                    },
                },
            },
        },
    });
}

function buildMetodosChart(canvas, data, theme) {
    return new Chart(canvas, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [
                {
                    data: data.valores,
                    backgroundColor: [theme.accent, theme.textPrimary, theme.textTertiary],
                    hoverBackgroundColor: [theme.accentStrong, theme.textPrimary, theme.textTertiary],
                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 18,
                },
            ],
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            animation: prefersReducedMotion() ? false : { duration: 650, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...baseTooltip(theme),
                    callbacks: {
                        label: (context) => formatCurrency(context.parsed.x),
                    },
                },
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: withAlpha(theme.border, 0.65) },
                    border: { display: false },
                    ticks: {
                        color: theme.textTertiary,
                        font: { size: 10 },
                        callback: (value) => formatCompactCurrency(value),
                    },
                },
                y: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: theme.textSecondary,
                        font: { size: 11, weight: '600' },
                    },
                },
            },
        },
    });
}

function buildPedidosChart(canvas, data, theme) {
    return new Chart(canvas, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Pedidos',
                    data: data.valores,
                    borderColor: theme.accent,
                    backgroundColor: (context) => areaGradient(context, theme.accent),
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: theme.accent,
                    pointHoverBorderColor: theme.surface,
                    pointHoverBorderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: prefersReducedMotion() ? false : { duration: 650, easing: 'easeOutQuart' },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...baseTooltip(theme),
                    callbacks: {
                        label: (context) => `${formatNumber(context.parsed.y)} ${context.parsed.y === 1 ? 'pedido' : 'pedidos'}`,
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: theme.textTertiary,
                        font: { size: 10, weight: '600' },
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: withAlpha(theme.border, 0.65) },
                    border: { display: false },
                    ticks: {
                        color: theme.textTertiary,
                        font: { size: 10 },
                        precision: 0,
                        callback: (value) => formatNumber(value),
                    },
                },
            },
        },
    });
}

function buildChart(canvas) {
    const type = canvas.dataset.dashboardChart;
    const theme = getTheme();

    try {
        const data = JSON.parse(canvas.dataset.chart || '{}');

        if (type === 'ingresos') {
            return buildIngresosChart(canvas, data, theme);
        }

        if (type === 'metodos') {
            return buildMetodosChart(canvas, data, theme);
        }

        if (type === 'pedidos') {
            return buildPedidosChart(canvas, data, theme);
        }
    } catch (error) {
        console.error('No se pudo iniciar el gráfico del dashboard.', error);
    }

    return null;
}

function destroyCharts() {
    charts.forEach((chart) => chart.destroy());
    charts.clear();

    document.querySelectorAll('[data-dashboard-chart]').forEach((canvas) => {
        delete canvas.dataset.chartInitialized;
    });
}

function observeTheme() {
    if (themeObserver) {
        lastDarkMode = getTheme().isDark;

        return;
    }

    lastDarkMode = getTheme().isDark;

    themeObserver = new MutationObserver(() => {
        const isDark = getTheme().isDark;

        if (isDark === lastDarkMode) {
            return;
        }

        lastDarkMode = isDark;

        if (rebuildFrame !== null) {
            cancelAnimationFrame(rebuildFrame);
        }

        rebuildFrame = requestAnimationFrame(() => {
            rebuildFrame = null;
            initDashboardCharts();
        });
    });

    themeObserver.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class'],
    });
}

export function initDashboardCharts() {
    const canvases = document.querySelectorAll('[data-dashboard-chart]');

    if (canvases.length === 0) {
        return;
    }

    destroyCharts();

    Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;
    Chart.defaults.font.size = 11;

    canvases.forEach((canvas) => {
        if (canvas.dataset.chartInitialized === 'true') {
            return;
        }

        const chart = buildChart(canvas);

        if (chart) {
            charts.set(canvas, chart);
            canvas.dataset.chartInitialized = 'true';
        }
    });

    observeTheme();
}

export function destroyDashboardCharts() {
    destroyCharts();
}

document.addEventListener('livewire:navigated', initDashboardCharts);
document.addEventListener('livewire:navigating', destroyDashboardCharts);
