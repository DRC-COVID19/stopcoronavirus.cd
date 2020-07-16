<template>
    <div class="legend-container">
        <div class="legend">
            <div class="no-data">
                <span class="lbl mb-1">Aucune donnée</span>
                <div class="range empty"
                     :class="{hover : legendHover !== null && legendHover.de === null }"
                     @mouseenter="setLegendHover({de : null, a : null})"
                     @mouseleave="setLegendHover(null)"></div>
            </div>
            <div class="datas">
                <div class="inner" v-for="(data, i) in colors[color]">
                    <span class="lbl">{{-100 + i * 25}}%</span>
                    <div class="range" :style="'background-color :' + data "
                        :class="{hover : legendHover !== null && legendHover.de == i * 25 }"
                        @mouseenter="setLegendHover({de : i * 25, a : (i-1) * 25})"
                        @mouseleave="setLegendHover(null)"></div>
                </div>
                <div class="inner inner-last">
                    <span class="lbl">100%</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {mapGetters, mapActions} from 'vuex'
    import {PALETTE} from '../config/env'

    export default {
        name: "Legend" ,
        mounted() {
            console.log(PALETTE)
        },
        data : function(){
            return {
                colors : [
                    PALETTE.inflow,
                    PALETTE.outflow,
                    PALETTE.present
                ],
            }
        } ,
        computed : {
            ...mapGetters(['fluxType', 'legendHover']),
            color : function(){
                // ['#053061','#2166AC','#4393C3','#92C5DE','#F4A582','#D6604D','#B2182B','#67001F'] ,
                //     ['#67001F','#B2182B','#D6604D','#F4A582','#92C5DE','#4393C3','#2166AC','#053061'] ,
                //     ['#B35806','#E08214','#FDB863','#FEE0B6','#92C5DE','#4393C3','#2166AC','#053061']
                if(this.fluxType){
                    if(this.colors[this.fluxType - 1]) return this.fluxType - 1
                    return 0
                }
                return 0
            }
        } ,
        methods : {
            ...mapActions(['setLegendHover'])
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
