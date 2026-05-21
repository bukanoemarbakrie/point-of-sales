<?php 
// function
function getStatus(int $status): string
{
    return $status ? '<span class="badge bg-primary">Active</span>':
    '<span class="badge bg-primary">Inactive</span>';
}


?>