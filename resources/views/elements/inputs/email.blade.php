@include('elements.inputs.input',[
    "required" => isset($required)?$required:"",
    "name"=>isset($name)?$name:'email',
    "class"=>"email"
])
