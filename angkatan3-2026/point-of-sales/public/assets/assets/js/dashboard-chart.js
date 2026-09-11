document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("salesChart");
    if (!ctx) return;

    let labels = [];
    let data = [];

    try {
        labels = JSON.parse(ctx.dataset.labels || "[]");
        data = JSON.parse(ctx.dataset.values || "[]");
    } catch (e) {
        console.warn("Failed to parse chart data:", e);
    }

    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Penjualan",
                    data: data,
                    borderColor: "#072F1F",
                    backgroundColor: "rgba(180, 241, 5, 0.2)",
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return "Rp " + value.toLocaleString("id-ID");
                        },
                    },
                },
            },
        },
    });
});
