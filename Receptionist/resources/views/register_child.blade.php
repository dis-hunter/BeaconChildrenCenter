<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
  <header>
  @include('logged_in_header')
</header>

<div class="container">
  <div class="row">
    <div class="col-md-5">

    </div>
<div class="col-md-7">
  

<form style="border: 2px solid black; margin-left: 10px; margin-top:10px;padding: 20px; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
  <h2 style="text-align: center; color:black; font-family: Arial, sans-serif;">Register a Child</h2>

  <div class="mb-3">
    <label for="child_name" class="form-label" style="font-weight: bold;">Child's Name</label>
    <input type="text" class="form-control" id="child_name" placeholder="Enter the child's name" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>

  <div class="mb-3">
    <label for="parent_name" class="form-label" style="font-weight: bold;">Parent's Name</label>
    <input type="text" class="form-control" id="parent_name" placeholder="Enter the parent's name" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>

  <div class="mb-3">
    <label for="guardian_contact" class="form-label" style="font-weight: bold;">Parent/Guardian's Contact</label>
    <input type="text" class="form-control" id="guardian_contact" placeholder="Enter the parent/guardian's contact" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>

  <div class="mb-3">
    <label for="dob" class="form-label" style="font-weight: bold;">Date of Birth</label>
    <input type="date" class="form-control" id="dob" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>

  <div class="mb-3">
    <label for="employer" class="form-label" style="font-weight: bold;">Employer Details</label>
    <input type="text" class="form-control" id="employer" placeholder="Enter the parent/guardian's employer details" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
  </div>

  <button type="submit" class="btn" style="width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; background-color: #30b9ec; border: none; color: white;">Submit</button>
</form>
</div>

</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  
</body>
</html>