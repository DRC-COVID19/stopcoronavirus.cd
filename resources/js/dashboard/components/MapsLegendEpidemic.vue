<template>
    <div class="legend-container">
        <div class="legend">
            <div class="datas">
                <div class="inner" v-for="(data, i) in colors" :key="i">
                    <span class="lbl">{{valAt(i)}}</span>
                    <div class="range" :style="'background-color :' + data "
                        :class="{hover : legendEpidHover !== null && legendEpidHover.de == valAt(i) }"
                        @mouseenter="setLegendEpidHover({de : valAt(i), a : valAt(i+1) })"
                        @mouseleave="setLegendEpidHover(null)"></div>
                </div>
                <div class="inner inner-last">
                    <span class="lbl">{{lastValue}}</span>
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
                colors : PALETTE.epidemic
            }
        } ,
        computed : {
            ...mapState({
                extValues: state => state.epidemic.epidemicExtValues,
                legendEpidHover : state => state.epidemic.legendEpidHover,
            }),
            pourcent : function(){
                //Calcul de la différence de marge entre chaque plage de la légende
                return Math.abs(this.extValues.max - this.extValues.min) / 4
            },
            lastValue(){
              return this.formatCash(Math.ceil(this.extValues.max))
            }
        } ,
        methods : {
            ...mapMutations(['setLegendEpidHover']),
            valAt : function(i){
                //Calcul de la valeur en pourcentage de l'extrimté d'une plage à l'index i
                const val = Math.floor(this.extValues.min + i * this.pourcent)
                return this.formatCash(val)
            }
        }
    }
</script>

<style scoped></style>
