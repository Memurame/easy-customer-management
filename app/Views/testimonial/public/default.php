

<style>
:root {
    --bebv-green1-rgb: 158,165,0;
    --bebv-red-rgb: 178,45,0;
    --bebv-blue-rgb: 0,105,140;
    --bebv-green2-rgb: 95,101,0;
    --bebv-brown-rgb: 140,105,0;

    --bebv-green1: #9ea500;
    --bebv-red: #b22d00;
    --bebv-blue: #00698c;
    --bebv-green2: #5f6400;
    --bebv-brown: #8c6900;


  }

.bebv-headerimage{
    height: 400px;
    background-size: cover;
    background-position: 50% 50%;
}

.bebv-bg-green1{
    background-color: rgba(var(--bebv-green1-rgb), var(--bs-bg-opacity)) ;
}
</style>
<main>
    <div class="container">
    <?php foreach($formFields['sections'] as $section): ?>    
        <?php foreach($section['fields'] as $fieldName => $field): ?>
            <div class="row p-3">
                <?php if($field['type'] == "text"): ?>
                    <h4><?=$field['title'] ?></h4>
                    <p><?=$testimonial->dataArray[$fieldName] ?></p>
                <?php endif; ?>

                <?php if($field['type'] == "select"): ?>
                    <h4><?=$field['title'] ?></h4>
                    <?php 
                        foreach($field['option'] as $value => $name){
                            echo '<li>'.$name.'</li>';
                        } 
                    ?>
                <?php endif; ?>

                <?php if($field['type'] == "textarea"): ?>
                    <h4><?=$field['title'] ?></h4>
                    <p><?=$testimonial->dataArray[$fieldName] ?></p>
                <?php endif; ?>

                <?php if($field['type'] == "checkbox" AND $testimonial->dataArray[$fieldName]){
                    echo "<h4>".$field['title']."</h4>";
                    foreach($testimonial->dataArray[$fieldName] as $key){
                        echo '<li>'.$field['option'][$key].'</li>';
                    } 
                }
                ?>


                <?php if($field['type'] == "upload"): ?>

                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    <?php endforeach; ?>
    
  </div>
</main>






