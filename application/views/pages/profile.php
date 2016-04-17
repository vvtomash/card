<script src="/static/js/Profile.js"></script>
<form class="form-profile" method="post" action="/profile/update">
	<fieldset class="form-group">
		<label for="first_name">Имя</label>
		<input type="text" name="first_name" class="form-control" id="first_name" value="<?=$profile->first_name?>" placeholder="Введите имя">
	</fieldset>
	<fieldset class="form-group">
		<label for="last_name">Фамилия</label>
		<input type="text" name="last_name" class="form-control" id="last_name" value="<?=$profile->last_name?>" placeholder="Введите фамилию">
	</fieldset>
	<fieldset class="form-group">
		<label for="phone">Телефон</label>
		<input type="text" name="phone" class="form-control" id="phone" value="<?=$profile->phone?>" placeholder="Введите телефон">
		<small class="text-muted">Телефон в международном формате +000(00)000-00-00.</small>
	</fieldset>
	<fieldset class="form-group">
		<label for="country">Страна</label>
		<input type="text" name="country" class="form-control" id="country" value="<?=$profile->country?>" placeholder="Введите страну">
	</fieldset>
	<fieldset class="form-group">
		<label for="city">Город</label>
		<input type="text" name="city" class="form-control" id="city" value="<?=$profile->city?>" placeholder="Введите город">
	</fieldset>
	<fieldset class="form-group">
		<label for="address">Адрес</label>
		<input type="text" name="address" class="form-control" id="address" value="<?=$profile->address?>" placeholder="Введите адрес">
		<small class="text-muted">Адрес смогут видеть другие пользователи, нужен для доставки карт.</small>
	</fieldset>
	<fieldset class="form-group">
		<label for="zip_code">Почтовый индекс</label>
		<input type="text" name="zip_code" class="form-control" id="zip_code" value="<?=$profile->zip_code?>" placeholder="Введите почтовый код">
	</fieldset>
	<button type="submit" class="btn btn-primary">Сохранить</button>
</form>