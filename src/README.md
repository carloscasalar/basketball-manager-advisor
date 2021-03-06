# The exercise

You have to write a simple command line ManagerAdvisor which is a basketball manager advisor. 
It should be able to manage team members, the team tactics and also be able to suggest the best tactic. 

The following use cases should be implemented:

## Add a team member
Each member has this attributes:
  - Uniform number.
  - Name in the back of the t-shirt.
  - Ideal role:
    - `Point Guard`.
    - `Shooting guard`. 
    - `Small Forward`.
    - `Power Forward`.
    - `Center`.
  - Coach score for the team member (integer from 0 to 100).
    
## Remove team member
Players should be removed by uniform number.

## Team member list
Should return a team member list in JSON format.
It should be able to order the list by any of the following criteria:
  - Uniform number.
  - Ideal rol and score.

## Tactics
The application must have these system default tactics:
  - `Defense 1-3-1`: Point Guard + Shooting Guard + Shooting Guard + Power Forward + Center   
  - `Zone defense 2-3`: Point Guard + Point Guard + Small Forward + Center + Power Forward
  - `Attack 2-2-1`: Point Guard + Small Forward + Shooting Guard + Center + Power Forward

## Create custom tactic
System should allow to add custom tactics defined as these:
  - Tactic name.
  - Role in position 1.
  - Role in position 2.
  - Role in position 3.
  - Role in position 4.
  - Role in position 5.

## List tactics
System should allow to print a tactic list (in any order), both system default and customized.    

## Remove a tactic
System should allow delete any customized tactic.

## Team's lineup calculator
Given a tactic the system should suggest the best tactic using the best scored player for each role.

## Operations history
System should store all create and delete operations made along with the time they were performed.

# Run the exercise     
    
Add a team member can be performed with this command:

    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/kata-football:/opt -w /opt shippingdocker/php-composer:latest php bin/console.php addTeamMember
    
To delete a team member:    

    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/kata-football:/opt -w /opt shippingdocker/php-composer:latest php bin/console.php deleteTeamMember
    
To list team members:
    
    docker run --rm -it -v /YOUR/LOCAL/PROJECTS/DIR/kata-football:/opt -w /opt shippingdocker/php-composer:latest php bin/console.php listTeamMembers
    
You can set the order list with `-o` option:
  * `ARBITRARY`. Members will be listed in an arbitrary order. This is de default option.
  * `UNIFORM_NUMBER`. Member list is ordered by uniform number ascendant.     
  * `ROLE_AND_SCORE`. Member list is ordered by role ascendant and score descendant.
  
You can also set the format of the list with `-f` option:
  * `TABLE`. Member list will be printed in a table.
  * `JSON`. Member list will be printed in JSON format.      
