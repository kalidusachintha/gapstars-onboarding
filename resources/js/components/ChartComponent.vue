<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">                    
                    <highcharts class="hc" :options="chartOptions" ref="chart"></highcharts>                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import onboarding from './../onboarding';
import {Chart} from 'highcharts-vue';
import Highcharts from 'highcharts'

    export default {

        components: {
            Highcharts,
            highcharts:Chart 
        },

        data() {
            return {
                chartdata:{},                
            }
        },

        computed : {
            chartOptions() {
                return {
                    series :this.chartdata,
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Onboarding Retention'
                    },
                    xAxis: {
                        categories: [
                            '0',
                            '20',
                            '40',
                            '50',
                            '70',
                            '90',
                            '99',
                            '100'
                        ], 
                        title: {
                            text: 'Onboarding Precentage'
                        },       
                    },
                    yAxis:{
                        labels :{
                            format: '{value}%'
                        }
                    },
                    tooltip: {
                        shared: true,
                        valueSuffix: ' %'
                    },
                }                
            }
        },
        created(){
            this.init();
        },
        methods : {
            /**
             * setup
             */
            async init() {
               await this.getOnboardingDetails();
            },
            /**
             * get onboarding steps precentage details
             * @returns {unresolved}
             */
            getOnboardingDetails() {
                 return onboarding.getAll().then(res =>{
                    const { status, message, data } = res;
                    this.chartdata = data;
                });
            }            
        }
    }
</script>
