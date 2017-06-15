<script type="application/tree" id="characteristicsearch">	
	<ul ng-show="!$parent.pipo">
		<li ng-repeat="child in children" rytree src="characteristicsearch" children="child.children">
			<div layout="row" layout-wrap layout-align="start center" ng-show="$root.match($root.characteristics.search, child.term.name)">
			<a href="#" ng-click="pipo=!pipo"><md-icon ng-show="!pipo" md-font-icon="fa fa-angle-down"></md-icon><md-icon ng-show="pipo" md-font-icon="fa fa-angle-right"></md-icon></a>
			<div layout="row" layout-align="start center">
				<div ng-if="child.id">
					<md-button class="md-icon-button" ng-click="child.value=$root.selectedText" aria-label="@lang("rycaracteres::overall.assign")"><md-icon md-font-icon="fa fa-long-arrow-right"></md-icon></md-button>
					<md-input-container>
						<label>@{{child.term.name}}</label>
						<input type="text" ng-model="child.value"/>
					</md-input-container>
				</div>
			</div>
			</div>
		</li>
	</ul>
</script>