<form action="/processsignup/" method="POST">
  User name: <input name="username" type="text" required><br />
  E-mail: <input name="email" type="text" pattern="^([a-zA-Z0-9_\-\.]+)@(([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))|(([01]?\d\d?|2[0-4]\d|25[0-5])\.){3}([01]?\d\d?|25[0-5]|2[0-4]\d))$" required><br />
  Password: <input name="password" type="password" required><br />
  <input value="Sign up" type="submit">
</form>
