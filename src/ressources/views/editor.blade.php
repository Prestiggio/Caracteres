<ul>
	<li ng-repeat="child in children" rytree src="characteristiceditor" children="child.children">
		<a class="toggle-accordion" href="#">fold/unfold</a>
		<div layout="row">
			<div ng-if="child.id">
				<md-button ng-click="$root.specifications[child.id]=selectedText">&gt;</md-button>
				<md-input-container>
					<label>@{{child.term.name}}</label>
					<input type="text" ng-model="$root.specifications[child.id]"/>
				</md-input-container>
			</div>
			<div ng-if="!child.id" layout="row">
				<md-button ng-click="$root.specifications[child.tempid]=selectedText">&gt;</md-button>
				<md-input-container>
					<label>Clé</label>
					<input type="text" ng-model="child.term.name" required/>
				</md-input-container>
				<md-input-container>
					<label>Valeur</label>
					<input type="text" ng-model="$root.specifications[child.tempid]"/>
				</md-input-container>
				<md-button ng-click="children.splice($index, 1)">-</md-button>
			</div>
			<md-button ng-click="addChild(child)">+ child</md-button>
		</div>
	</li>
</ul>