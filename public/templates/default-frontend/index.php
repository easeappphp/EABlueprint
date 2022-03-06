<!DOCTYPE html>
<html>
 <body>
 <h1>DEFAULT FRONTEND - <?=$name?></h1>
 <div><?php echo $place; ?></div>
 <div><?php echo htmlspecialchars("Srirama<script>Antabagundali", ENT_QUOTES); ?> <br><br>
 <?php 
echo "userSessionInfo: " . $userSessionInfo . "<br>";
echo "home_area: " . $home_area . "<br>";
echo "request time in seconds: " . $requestTimeInSeconds . "<br>";
 //$this->session->get('Srirama');  ?>
 </div>
 
 </body>
</html>