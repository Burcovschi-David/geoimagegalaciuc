<h1>Welcome on our website</h1>

<h3>Enter pictures to check if was made at Galaciuc</h3>

<form action="/check-pictures" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<input type="file" name="pictures[]" multiple><br><br>
	<input type="submit" value="Trimite!">
</form>