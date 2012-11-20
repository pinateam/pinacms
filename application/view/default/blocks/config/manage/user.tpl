<h1><span class="section-icon icon-colors"></span> Настройки профилей пользователей</h1>

<form action="" method="POST">

	<div class="right-narrow-column">

		<fieldset class="operations">
			<h2>Операции</h2>
			<div class="button-bar">
				<button class="css3">{lng lng="save"}</button>
				<button class="css3 additional">{lng lng="cancel"}</button>
			</div>
		</fieldset>

		<fieldset class="operations bottom">
			<h2>Операции</h2>
			<div class="button-bar">
				<button class="css3">{lng lng="save"}</button>
				<button class="css3 additional">{lng lng="cancel"}</button>
			</div>
			<div class="button-bar-2">
				<button class="css3 delete">{lng lng="delete"}</button>
			</div>
		</fieldset>

	</div>

	<div class="left-wide-column">

		<fieldset>
			<h2>Адреса <span class="icon-info" onclick="alert('This is help')"></span></h2>
			<div class="field">
				<label for="option-1">Короткий текст <span class="icon-info" onclick="alert('This is help')"></span> <span class="error">Механизм по укладке опций в 2, 3 и 4 колонки действует и тут</span></label>
				<input id="option-1" type="text" class="short-text" />
			</div>
			<div class="field">
				<label for="option-2">Длинный текст <span class="icon-info" onclick="alert('This is help')"></span></label>
				<input id="option-2" type="text" class="long-text" />
			</div>
			<div class="field">
				<label for="option-3">Многострочный текст <span class="icon-info" onclick="alert('This is help')"></span></label>
				<textarea id="option-3" class="html-text" rows="3" cols="50"></textarea>
			</div>
			<div class="field">
				<label for="option-4">Переключатель (сплиттер): Вкл/Выкл <span class="icon-info" onclick="alert('This is help')"></span></label>
				<input id="option-4" type="hidden"/>
				<ul class="splitter">
					<li class="first green"><a href="#" class="selected" data-value="on">Вкл</a></li><li class="last red"><a href="#" data-value="off">Выкл</a></li>
				</ul>
			</div>
			<div class="field">
				<label for="option-5">Переключатель (сплиттер): многосекционный <span class="icon-info" onclick="alert('This is help')"></span></label>
				<input id="option-5" type="hidden"/>
				<ul class="splitter">
					<li class="first orange"><a href="#" data-value="option-1">Опция 1</a></li><li class="orange"><a href="#" class="selected" data-value="option-2">Опция 2</a></li><li class="last orange"><a href="#" data-value="option-3">Опция 3</a></li>
				</ul>
			</div>
			<div class="field">
				<label for="option-6">Выпадающий список <span class="icon-info" onclick="alert('This is help')"></span></label>
				<select id="option-6">
					<option>Вариант 1</option>
					<option>Вариант 2</option>
					<option>Вариант 3</option>
					<option>Очень-очень-очень-очень-очень длинный вариант 4</option>
				</select>
			</div>
			<div class="bulb-hint">
				Можно вывести <strong>подсказку-лампочку</strong>, если очень хочется о чём-то <strong><a class="ajax" href="#">сказать</a></strong>, но мы <strong><a href="#">боимся</a></strong> что пользователь не станет читать помощь.
			</div>
			<div class="field">
				<label for="option-7-1">Набор флажков <span class="icon-info" onclick="alert('This is help')"></span></label>

				<input id="option-7-1" type="checkbox" />
				<label class="sub" for="option-7-1">флажок 1</label>

				<input id="option-7-2" type="checkbox" />
				<label class="sub" for="option-7-2">флажок 2</label>

				<input id="option-7-3" type="checkbox" />
				<label class="sub" for="option-7-3">флажок 3</label>

				<input id="option-7-4" type="checkbox" />
				<label class="sub" for="option-7-4">флажок 4</label>
			</div>

		</fieldset>

		<fieldset>
			<h2>Секция 2я, и, возможно, не последняя <span class="icon-info" onclick="alert('This is help')"></span></h2>
			<div class="field">
				<label for="option-8">Опция <span class="icon-info" onclick="alert('This is help')"></span></label>
				<input id="option-8" type="text" class="long-text" />
			</div>
			<div class="field">
				<label for="option-9">Опция <span class="icon-info" onclick="alert('This is help')"></span></label>
				<input id="option-9" type="text" class="long-text" />
			</div>
		</fieldset>

	</div>

</form>