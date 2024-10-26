import Chart from "chart.js/auto";

/**
 * チームポイント推移表を生成する
 *
 * @param {*} id
 * @param {*} data
 */
window.makeTeamPointChart = function (id, data) {

    /**
     * チームポイントを取得する
     * @param {*} teamName
     * @param {*} datasets
     * @returns
     */
    const getTeamPoint = function (teamName, datasets) {
        // チーム名でフォルターしているため、必ず1つに絞り込まれる
        // また、配列での結果取得は不要なので[0]を指定している
        const dataset = datasets.filter(element => {
            return element.label === teamName;
        })[0];

        // ポイントには累積ポイントが格納されているため
        // 最後の値を取得すればOK
        return parseFloat(dataset.data.at(-1));
    };

    /**
     * 凡例をチームポイントで降順でソートする
     * @param {LegendItem} a 比較のための最初の要素。未定義になることはない。
     * @param {LegendItem} b 比較のための2番目の要素。未定義になることはない。
     * @param {ChartData} data
     */
    const sortLegend = function (a, b, data) {
        // 2番目の値が大きい場合、降順でソートされる
        return getTeamPoint(b.text, data.datasets) - getTeamPoint(a.text, data.datasets);
    };

    const ctx = document.getElementById(id);
    const myChart = new Chart(ctx, {
        type: "line",
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: { // 凡例
                    display: true,
                    position: 'right',
                    labels: {
                        color: '#ffffff',
                        padding: 20,
                        sort: sortLegend,
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#ffffff',
                        font: {
                            size: 14,
                        },
                    },
                },
                y: {
                    border: {
                        display: false,
                    },
                    grid: {
                        color: context => context.tick.value === 0 ? '#ffffff' : '#888888'
                    },
                    ticks: {
                        color: '#ffffff',
                        font: {
                            size: 14,
                        },
                    },
                },
            },
        },
    });
};
