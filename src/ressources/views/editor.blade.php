<script type="application/tree" id="characteristiceditor">	
	<ul ng-show="!$parent.pipo">
		<li ng-repeat="child in children" rytree src="characteristiceditor" ng-if="!child.deleted" children="child.children">
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
				<div ng-if="!child.id" layout="row" layout-align="start center">
					<md-button class="md-icon-button" ng-click="child.value=$root.selectedText" aria-label="@lang("rycaracteres::overall.assign")"><md-icon md-font-icon="fa fa-long-arrow-right"></md-icon></md-button>
					<md-input-container>
						<label>Clé</label>
						<input type="text" ng-model="child.term.name" required/>
					</md-input-container>
					<md-input-container>
						<label>Valeur</label>
						<input type="text" ng-model="child.value"/>
					</md-input-container>					
				</div>
				<md-input-container>
					<md-button class="md-icon-button" ng-click="$root.specify(child)" aria-label="Questionner l'auteur"><md-icon md-font-icon="fa fa-send"></md-icon></md-button>
				</md-input-container>
				<md-button class="md-icon-button" ng-click="child.deleted=true" aria-label="@lang("rycaracteres::overall.removechild")"><md-icon md-font-icon="fa fa-minus-circle"></md-icon></md-button>
				<md-button class="md-icon-button" ng-click="addChild(child)" aria-label="@lang("rycaracteres::overall.addchild")"><md-icon md-font-icon="fa fa-plus-circle"></md-icon></md-button>
			</div>
			</div>
		</li>
	</ul>
</script>