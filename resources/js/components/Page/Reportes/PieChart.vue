<script>
import VueCharts from 'vue-chartjs'
import { Doughnut } from 'vue-chartjs'

export default {
  extends: Doughnut,
  props: ["data"],
  data(){
        return{
            options:{
                        hoverBorderWidth: 20
                    }
        }
  },
  mounted() {
    // this.chartData is created in the mixin.
    // If you want to pass options please create a local options object
    this.renderChart(this.data, this.options);
  },
  watch: {
    data: function() {
      console.log('watch');
      this._chart.destroy();
      this.renderChart(this.data, this.options);
    }
  }
};
</script>
