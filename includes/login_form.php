<form action="/processlogin/" method="POST">
  User name: <input name="username" type="text" required><br />
  Password: <input name="password" type="password" required>
  <script type="application/javascript">
    $("input:password").chromaHash({bars: 4, salt: "324hjkg5o8f8dgiyud76sdh50mnb9wd6fkx8lcvud0fg87", minimum: 2});
  </script>
  <br />
  <input value="Login" type="submit">
</form>
