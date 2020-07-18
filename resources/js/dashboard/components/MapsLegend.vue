<template>
    <div class="legend-container">
        <div class="legend">
            <div class="no-data" :style="'background-color : ' + color_nodata">
                <span class="lbl mb-1">Aucune donnée</span>
                <div class="range empty"
                     :class="{hover : legendHover !== null && legendHover.de === null }"
                     @mouseenter="setLegendHover({de : null, a : null})"
                     @mouseleave="setLegendHover(null)"></div>
            </div>
            <div class="datas">
                <div class="inner" v-for="(data, i) in colors[color]" :key="i">
                    <span class="lbl">{{valDe(i)}}%</span>
                    <div class="range" :style="'background-color :' + data "
                        :class="{hover : legendHover !== null && legendHover.de == valDe(i) }"
                        @mouseenter="setLegendHover({de : valDe(i), a : valDe(i+1) })"
                        @mouseleave="setLegendHover(null)"></div>
                </div>
                <div class="inner inner-last">
                    <span class="lbl">{{Math.ceil(domaineExtValues.max)}}%</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import { mapGetters, mapMutations, mapState } from 'vuex';
    import {PALETTE} from '../config/env'

    export default {
        name: "Legend" ,
        data : function(){
            return {
                colors : [
                    PALETTE.inflow,
                    PALETTE.outflow,
                    PALETTE.present
                ],
                color_nodata :  PALETTE.nodata
            }
        } ,
        computed : {
            ...mapGetters(['fluxType', 'legendHover']),
            ...mapState({
                domaineExtValues: state => state.flux.domaineExtValues
            }),
            color : function(){
                if(this.fluxType){
                    if(this.colors[this.fluxType - 1]) return this.fluxType - 1
                    return 0
                }
                return 0
            },
            pourcent : function(){
                return Math.abs(this.domaineExtValues.max - this.domaineExtValues.min) / 8
            }
        } ,
        methods : {
            ...mapMutations(['setLegendHover']),
            valDe : function(i){
                return Math.floor(this.domaineExtValues.min + i * this.pourcent)
            }
        }
    }
</script>

<style scoped>
    .legend-container{
        position : relative ;
        top: -50px;
        left: 50%;
        transform: translateX(-50%);
        height: 0px;
        z-index: 2;
    }
    .legend{
        display : flex ;
        align-items: flex-end;
    }
    .no-data{
        margin-right: 25px;
    }
    .range{
        width: 50px;
        height: 12px;
        border: 2px solid rgba(0, 0, 0, .3) ;
        position: relative;
        transition: border 0.3s ease-in-out;
    }
    .range.hover {
        border: 2px solid black ;
    }
    .range.empty{
        background-color: #eee ;
    }
    .datas .inner:nth-child(2n+1) .range::before,
    .datas .inner:nth-last-child(2) .range::after{
        content: "";
        display: block;
        height: 25px;
        background-color: black ;
        width: 1px;
        position: absolute;
        bottom: 0px;
    }
    .datas .inner:nth-child(2n+1) .range::before{
        left: -2px;
    }
    .datas .inner:nth-last-child(2) .range::after {
        right: -2px;
    }
    .datas{
        display: flex;
    }
    .lbl{
        font-size: 12px ;
        max-width: 50px;
        display: inline-block;
        line-height: 12px;
    }
    .datas .lbl{
        transform: translateX(-50%);
        transform-origin: center;
        position: relative;
    }
    .datas .inner-last .lbl{
        position: relative;
        top: 0px;
    }
    .datas .inner:nth-child(2n+1) .lbl {
        top: -17px;
    }
</style>
