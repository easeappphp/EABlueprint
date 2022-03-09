
 <h1>Welcome to <?=$name?></h1>
 <div><?php echo htmlspecialchars("A simple <script>PHP based framework", ENT_QUOTES); ?> <br><br>
 <?php 
echo "userSessionInfo: " . $userSessionInfo . "<br>";
echo "license: " . $license . "<br>";
echo "request time in seconds: " . $requestTimeInSeconds . "<br>";
 ?>
 </div>
