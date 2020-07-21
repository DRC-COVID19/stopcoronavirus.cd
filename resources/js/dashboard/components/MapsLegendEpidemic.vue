<template>
    <div class="legend-container">
        <div class="legend">
            <div class="no-data">
                <span class="lbl mb-1">Aucune donnée</span>
                <div class="range empty" :style="'background-color : ' + color_nodata"
                     :class="{hover : legendEpidHover !== null && legendEpidHover.de === null }"
                     @mouseenter="setLegendEpidHover({de : null, a : null})"
                     @mouseleave="setLegendEpidHover(null)"></div>
            </div>
            <div class="datas">
                <div class="inner" v-for="(data, i) in colors" :key="i">
                    <span class="lbl">{{valDe(i)}}%</span>
                    <div class="range" :style="'background-color :' + data "
                        :class="{hover : legendEpidHover !== null && legendEpidHover.de == valDe(i) }"
                        @mouseenter="setLegendEpidHover({de : valDe(i), a : valDe(i+1) })"
                        @mouseleave="setLegendEpidHover(null)"></div>
                </div>
                <div class="inner inner-last">
                    <span class="lbl">{{Math.ceil(extValues.max)}}%</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import { mapGetters, mapMutations, mapState } from 'vuex';
    import {PALETTE} from '../config/env'

    export default {
        name: "LegendEpidemic" ,
        data : function(){
            return {
                colors : PALETTE.epidemic ,
                color_nodata :  PALETTE.nodata
            }
        } ,
        computed : {
            ...mapState({
                extValues: state => state.flux.epidemicExtValues,
                legendEpidHover : state => state.flux.legendEpidHover,
            }),
            pourcent : function(){
                return Math.abs(this.extValues.max - this.extValues.min) / 4
            }
        } ,
        methods : {
            ...mapMutations(['setLegendEpidHover']),
            valDe : function(i){
                return Math.floor(this.extValues.min + i * this.pourcent)
            }
        }
    }
</script>

<style scoped src="./MapsLegend.css"></style>
