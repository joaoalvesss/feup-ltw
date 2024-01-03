<?php function draw_faq($db, $is_agent) { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <meta charset="UTF-8">
	        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="../css/faq.tpl.css">
        </head>
        
        <body>
            <div id="container">
                <h2>F.A.Q.</h2>
                <div id='box'>

                
                <div id="faq-container">
                    <?php
                    $qry = 'SELECT * FROM faqs';
                    $stmt = $db->prepare($qry);
                    $stmt->execute();
                    $faqs = $stmt->fetchAll();

                    foreach($faqs as $faq){
                        $id = $faq['id'];
                        $question = $faq['question'];
                        $answer = $faq['answer'];

                        echo "<div id='question'>";
                        echo "<h3>$question</h3>";
                        echo "<h4>$answer</h4>";
                        if($is_agent){
                        echo "<form action='/../actions/action_remove_faq.php' method='post' class='remove'>
                            <input type='hidden' id='faq_id' name='faq_id' value=$id>
                            <button type='submit'>-</button>
                        </form>";
                        }
                        echo "</div>";
                        
                    }
                    ?>
                </div>
                    <?php if($is_agent){
                            echo "<div id='new-faq'>";
                            echo "<h3>Create new FAQ</h3>";
                            echo "<form action='/../actions/action_create_faq.php' method='post' class='new_faq'>
                                <label for='new_question'>New question:</label>
                                <input type='text' name='new_question' id='new_question' placeholder='Enter new question' required>
                                <label for='new_answer'>New answer:</label>
                                <input type='text' name='new_answer' id='new_answer' placeholder='Enter new answer' required>
                                <button type='submit'>Add</button>
                            </form></div>";
                    }
                    
                    ?> 
                
                </div>
                </div>
        </body>   
    </html>
<?php } ?>