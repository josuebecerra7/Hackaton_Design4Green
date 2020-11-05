<!-- Desgin4Green Hackaton, Index of Fragility Website Tool -->
<html lang="en">
<head>
	<!-- Layout of the website, the colors are specified in the styles.css file -->
	<meta charset="utf-8">
	<meta name="keywords" content="Index, Digital, Fragility, Numerical, Competences, Access, Information, Administrative">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index of Fragility</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<style>
		th { width : 200px; 
			position : center;
			border: 1px solid ;
		}
	</style>
</head>
<!-- Body of the website -->
<body>
	<div id="content">
		<header>
			<h1>Index of Digital Fragility</h1>
			<small>Design4Green</small>
		</header>
		<!-- Introduction to the index of fragility and the tool -->
		<section id="main_section" align = "justify">
			<h2>What is the Index of Digital Fragility? and What does it mean?</h2>
			<p>The digital fragility index is a tool made by the SGAR Occitanie with the ANSA and Mednum during the IncubO.<br>
				Its goal is to be used by the representative to help them to take decision about the digital inclusion on there territory.
				<h3>Why is the index of fragility important?</h3>
				<p>
					- There is more and more procedures that must be made online nowaday and less people to interact with<br>
					- Some people (in particular our elders, but not only) have troubles with new technologies and need some help using computers.<br>
					- Some people can't afford for this technologies and can't make the procedures as they would.<br>
					- Some people, due to the fact a website is a robot and can't interact as a human, are not aware of the procedure they have to or can do.<br>
					- There are location in those territory that are not wall suited with good bandwidth making the using of website painful or impossible<br>
				</p>
				<p>This tool compile all these things with some index, so the representatives can use it to help taking some decisions and spend public money the wiser<br>
					This index show the probability for a given zone, that a significative part of the population is in situation of digital exclusion, this mean they are not able to use it properly.<br>
					This can be due to many different reasons.<br> Those reason can be evaluated thanks to the 4 other index we are sharing.<br>
					- Access to digital interfaces : Identify poorly deserved territories by network, or where populations would have financial troubles to access<br>
					- Access to the information : Identify territories where people would have issue accessing the information or troubles understanding it<br>
					- Numerical competences: Identify territories where people have issues using new technologies<br>
					- Paperwork competences: Identify territories where people have issues with paperwork (for example, young people unexperienced, or non native speaker)<br>
				</p>
			</section>
			<!-- Section where the user can use the tool -->
			<section id="secondary_section" align = "justify">
				<h2>Do you want to know the Index of Fragility in your area?</h2>
				<p> You just need your Postal Code, if you do not know it you can find it on <a href="https://www.code-postal.com/" target="popup">code-postal.</a></p>
				<form method="post"  label="pc2">
					<label>Enter your Postal Code here: </label>
					<input type="number" name="area_name" label="pc"><br>
					<button type="submit" name="submit">Submit</button>
				</form>
				<!-- PHP code handling the formulaire and looking into the preprocessed database with the results -->
				<?php
				$conn = new PDO("mysql:host=localhost;dbname=trial", "fatima", "admin");
				if(isset($_POST['submit']))
				{
					$area_name = $_POST['area_name'];
					$sql= $conn-> prepare("Insert into tblarea (area_name)
						values (:area_name)");
					$conn->beginTransaction();
					$sql->execute(array(':area_name'=>$area_name));
					file_put_contents('filename.txt', $area_name); 
					$conn->commit();
					$db = mysqli_connect("localhost","fatima","admin","trial");
		                $records = mysqli_query($db, "SELECT COM,name_commune,global_score,dpt_score,region_score,index1,index2,index3,index4,dept_name,region_name From data_13k where COM=$area_name");  // Use select query here
		                $data = mysqli_fetch_array($records);
		                if ($data == Null){
		                	echo "Your Post Code was not found, please enter a valid one.";
		                } else{
		                // Presentation of results
		                	echo "
		                	<div id='customers'>
		                	<table  >
		                	<tr>
		                	<th > <p  id='bypassme'>Postal code</p></th>
		                	<th ><p >Commune name</p></th>
		                	<th >Global score</th>
		                	<th>Department score</th>
		                	<th>Region score</th>
		                	<th>Access to Digital Interfaces</th>
		                	<th>Access to the information</th>
		                	<th>Numerical competences</th>
		                	<th>Paperwork competences</th>
		                	</tr>
		                	<tr>
		                	<th>" . $data['COM'] . "</th>
		                	<th>" . $data['name_commune'] . "</th>
		                	<th>" . $data['global_score'] . "</th>
		                	<th>" . $data['dpt_score'] . "</th>
		                	<th>" . $data['region_score'] . "</th>
		                	<th>" . $data['index1'] . "</th>
		                	<th>" . $data['index2'] . "</th>
		                	<th>" . $data['index3'] . "</th>
		                	<th>" . $data['index4'] . "</th>
		                	</tr>
		                	</table>
		                	<!-- Conclusion of the results -->
		                	<h2> Conclusion </h2>
		                	<p> These results represent all variables of the commune researched, it shows that:</p>
		                	<ul>
		                	<li>The digital fragility index of " . $data['name_commune'] . " " . $data['COM'] . " is  " . $data['global_score'] . ". </li>
		                	<li>The score of its department called " . $data['dept_name']  . "  is " . $data['dpt_score'] . ". </li>
		                	<li>And for its region called " . $data['region_name'] . " is " . $data['region_score'] . ". </li> </ul>
		                	</div>";
		                	if($data['global_score'] < 0.5 * $data['dpt_score']){	
		                		echo '<p> Your municipality is in a good position, and your population tends to have better access to the information compared to your departement.</p>';
		                	}else{ 
		                		if( $data['global_score'] < 0.9 * $data['dpt_score']){
		                			echo '<p>Compared to your department, your municipality is quite good, but there is still room for improvement.</p>';
		                		}else{ 
		                			if($data['global_score'] < 1.1 * $data['dpt_score']){
		                				echo '<p>Your municipality has about the same result as your department, maybe you should do some investments to be one of the leaders of the digital transition in your department and get your citizens a better life </p>';
		                			}else{  
		                				if( $data['global_score'] < 1.5 * $data['dpt_score']){
		                					echo '<p>Your municipality seems to be late for the digital transition in your department, you should take action so your citizens won\'t be in trouble in the near futur </p>';
		                				}else{
		                					echo '<p>Your municipality is behind in the digital transition compared to your department, you must take wise decisions, otherwise your citizens might become unable to adapt and overwhelmed by this transition soon.</p>';
		                				}
		                			}
		                		}
		                	}
		                	if($data['dpt_score'] < 0.9 * $data['region_score']){
		                		echo '<p>Your departement seems to be one of the leaders of your region when it comes to the digital transition, this is good.</p>';
		                	}else{
		                		if($data['dpt_score'] < 1.1 * $data['region_score']){
		                			echo '<p>Your departement is in the mean of your region in the digital transition, try to improve the decisions to get your municipality and departement to be one of the leaders of the digital transition </p>';
		                		}else{
		                			echo '<p>Your departement seems to be behind compared to your region in the digital transition, try to work at a higher level than the municipality to get a global line of conducts to pursue the transition</p>';
		                		}
		                	}
		                }
		            }
		            ?>
		            <p align = "justify"> <h2>Reminder:</h2> 
		            	You must corroborate those values with local and on the fields enquery. <br>
		            	Moreover and most importantly, those values aren't exact. They are calculated out of databases that might not be up to date, or totally incomplete for different reasons such as absence of enquery in those locations, information not sent by municipalities or privacy reasons.<br>
		            	Other statistics should be taken into account but aren't available at this level; for example the rate of illetrism or the frequency of internet usage that can't be known by municipalities.<br>
		            	In addition, comparison between small communities, especially those situated in province should be avoided since their population isn't big enough and therefore some services aren't available.<br>
		            </p>
		            <!-- Button to generate PDF with results and conclusion -->
		            <button onclick="javascript:demoFromHTML();">PDF of Results</button>
		        </form>
		    </section>
		    <!-- Footer of the website -->
		    <footer>
		    	<p align="center">Copyright (c) 2020   -   Team 19</p>
		    </footer>
		</div>
		<!-- Javascript Libraries  -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.1.1/jspdf.umd.min.js"></script>
		<script src="jspdf.debug.js"></script>
		<script src="script.js"></script>
	</body>
	</html>