<?php
echo "<div style='font-size: 36px; text-align: center;'>Please Contact Your <b style='color:blue;'>Administrator!!</b></div> "
?>
<style>
    button{
    background-color: rgb(255, 213, 0);
    color: #000;
    font-size: 18px;
    padding: 14px 20px;
    font-weight: 600;
    margin: 15px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.10s;
  }
    .cancel-container {
    display: flex;
    align-items: center;
    justify-content:center;
  }
  
  .cancelbtn {
    height: 40px;
    align-items: center;
    justify-content: center;
    background-color: red;
    color: #f1f1f1;
    font-size: 16px;
    border-radius: 5px;
    margin-top: 10px;
  }
  
  .cancelbtn:hover {
    background-color: rgb(157, 0, 0);
  }
  
</style>
<div class="cancel-container">
    <a href="mailto:gbenartey19@gmail.com">
    <button type="button" class="cancelbtn">Send Email</button>
    </a>
</div>