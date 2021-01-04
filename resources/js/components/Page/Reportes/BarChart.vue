<script>
    import VueCharts from 'vue-chartjs'
    import { Bar } from 'vue-chartjs'

    export default {
        extends: Bar,
        props: {
            chartdata: {
                type: Object,
                default: null
            }
        },
        data(){
            return{
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            }
        },
        mounted () {
            console.log('Montando Chart');
            this.renderChart(this.chartdata, this.options)
        }
    }
</script>

<style>
</style>
