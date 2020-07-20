<template>
	<div class="indicateurChart">
		<b-row class="pt-3 pb-3">
			<b-col class="pr-1" cols="12" md="6">
				<b-card class="no-body card-chart">
					<p class="text-muted text-center">Scatter Plot X vs Y</p>
				</b-card>
			</b-col>

			<b-col class="pl-1" cols="12" md="6">
				<b-card class="no-body card-chart">
					<p class="text-muted text-center">Evolution indicateur X sur le temps :
						Linearchart x vs temps </p>
				</b-card>
			</b-col>
		</b-row>
	</div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
	.indicateurChart{
		height: calc(100vh - 175px);
        > .row{
            height: 100%;
            .card-chart{
                height: 100%;
            }
        }
	}
</style>
