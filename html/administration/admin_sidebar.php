<html>
    <body onload="showLink();"></body>
    
    <script type="text/javascript">
        function showLink()
        {
            var value = "<?php echo $_SESSION['administration_role'] ?>"
            switch(value){
                case 'ADMIN':
                
                    document.getElementById('partyLink').style.display = 'block';
                    document.getElementById('scheduleLink').style.display = 'block';
                    document.getElementById('doLink').style.display = 'block';
                    document.getElementById('candidateLink').style.display = 'block';
                    document.getElementById('voterLink').style.display = 'block';
                    document.getElementById('districtLink').style.display = 'block';
                    document.getElementById('divisionLink').style.display = 'block';
                    document.getElementById('inspectorLink').style.display = 'block';
                    document.getElementById('aeoLink').style.display = 'block';
                    document.getElementById('resultLink').style.display = 'block';
                    break;
                    
                case 'AEO':
                
                    //document.getElementById('partyLink').style.display = 'block';
                    //document.getElementById('scheduleLink').style.display = 'block';
                    document.getElementById('doLink').style.display = 'block';
                    document.getElementById('candidateLink').style.display = 'block';
                    document.getElementById('voterLink').style.display = 'block';
                    //document.getElementById('districtLink').style.display = 'block';
                    document.getElementById('divisionLink').style.display = 'block';
                    document.getElementById('inspectorLink').style.display = 'block';
                    //document.getElementById('aeoLink').style.display = 'block';
                    //document.getElementById('resultLink').style.display = 'block';
                    break;
                    
                case 'DO':
                
                    //document.getElementById('partyLink').style.display = 'block';
                    //document.getElementById('scheduleLink').style.display = 'block';
                    //document.getElementById('doLink').style.display = 'block';
                    //document.getElementById('candidateLink').style.display = 'block';
                    document.getElementById('voterLink').style.display = 'block';
                    //document.getElementById('districtLink').style.display = 'block';
                    //document.getElementById('divisionLink').style.display = 'block';
                    //document.getElementById('inspectorLink').style.display = 'block';
                    //document.getElementById('aeoLink').style.display = 'block';
                    //document.getElementById('resultLink').style.display = 'block';
                    break;
                
            }
        }
    </script>
    
    <!-- icon that shows when the sidebar is hidden -->
    <a id="show-sidebar" class="btn btn-sm" href="#">
        <i class="fas fa-list"></i>
    </a>

    <!-- sidebar -->
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <!-- logo -->
                <a href="admin_dashboard.php"><img src="../../img/logoForAdmin.png" width="100%"></a>
                <!-- sidebar hidden icon -->
                <div id="close-sidebar">
                    <i class="fas fa-times"></i>
                </div>
            </div>

            <div class="sidebar-header">
                <!-- user's picture -->
                <div class="user-pic">
                    <img class="img-responsive img-rounded" src="../../img/admin.png" alt="User picture">

                </div>
                
                <div class="user-info">
                    <!-- display user's name -->
                    <span class="user-name">
                        <strong>
                            <?php
                                echo $_SESSION['administration_name'];
                            ?>
                        </strong>
                    </span>
                    <!-- display user's role -->
                    <span class="user-role">
                        <?php
                            if($_SESSION['administration_role']=='ADMIN'){
                                echo 'Administrator';
                            }else if($_SESSION['administration_role']=='AEO'){
                                echo 'Assistant Election Officer';
                            }else if($_SESSION['administration_role']=='DO'){
                                echo 'Division Officer';
                            }
                        
                            echo " | ".$_SESSION['administration_nic'];
                        
                        ?>                                    
                    </span>
                    <span class="user-status"><i class="fa fa-circle"></i><span>Online</span></span>
                </div>
                
            </div>
            <!-- sidebar-header  -->

            <div class="sidebar-menu">
                <ul>                            
                    <li><a href="admin_dashboard.php"><i class="fa fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    
                    
                    <li class="sidebar-dropdown" id="districtLink" style="display:none;"><a href="#"><i class="fas fa-project-diagram"></i><span>District</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <?php
                                    if($_SESSION['administration_role']=='ADMIN'){
                                ?>
                                <!--li><a href="admin_addDivision.php">Add Division</a></li-->
                                <?php
                                    }
                                ?>
                                <li><a href="admin_districtList.php">District List</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="sidebar-dropdown" id="divisionLink" style="display:none;"><a href="#"><i class="fas fa-bezier-curve"></i><span>Division</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <?php
                                    if($_SESSION['administration_role']=='ADMIN'){
                                ?>
                                <!--li><a href="admin_addDivision.php">Add Division</a></li-->
                                <?php
                                    }
                                ?>
                                <li><a href="admin_divisionList.php">Division List</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="sidebar-dropdown" id="partyLink" style="display:none;"><a href="#"><i class="fas fa-building"></i><span>Party</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <?php
                                    echo "<li><a href='admin_addParty.php'>Add Party</a></li>";
                                ?>
                                <li><a href="admin_partyList.php">Party List</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="sidebar-dropdown" id="aeoLink" style="display:none;"><a href="#"><i class="fas fa-user-tie"></i><span>Assistant Election Officer</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li><a href="admin_changeAssistantElectionOfficer.php">Change Assistant Election Officer</a></li>
                                <li><a href="admin_assistantElectionOfficerList.php">Assistant Election Officer List</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-dropdown" id="doLink" style="display:none;"><a href="#"><i class="fas fa-user-tie"></i><span>Division Officer</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <?php
                                    if($_SESSION['administration_role']=='AEO'){
                                ?>
                                <li><a href="admin_changeDivisionOfficer.php">Change Division Officer</a></li>
                                <?php
                                    }
                                ?>
                                <li><a href="admin_divisionOfficerList.php">Division Officer</a></li>
                             </ul>
                        </div>
                    </li>
                    
                    <li class="sidebar-dropdown" id="inspectorLink" style="display:none;"><a href="#"><i class="fas fa-user-tag"></i><span>Inspector</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <?php
                                    if($_SESSION['administration_role']=='AEO'){
                                ?>
                                <li><a href="admin_addInspector.php">Add Inspector</a></li>
                                <?php
                                    }
                                ?>
                                <li><a href="admin_inspectorList.php">Inspector List</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-dropdown" id="candidateLink" style="display:none;"><a href="#"><i class="fas fa-user-tie"></i><span>Candidate</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li><a href="admin_addCandidate.php">Add Candidate</a></li>
                                <li><a href="admin_candidateList.php">Candidate List</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="sidebar-dropdown" id="voterLink" style="display:none;"><a href="#"><i class="fas fa-user"></i><span>Voter</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <?php
                                    if($_SESSION['administration_role']=='DO'){
                                ?>
                                <li><a href="admin_addVoter.php">Add Voter</a></li>
                                <?php
                                    }
                                ?>
                                <li><a href="admin_voterList.php">Voter List</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-dropdown" id="scheduleLink" style="display:none;"><a href="#"><i class="far fa-calendar-alt"></i><span>Election Schedule</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li><a href="admin_addElectionSchedule.php">Add Election Schedule</a></li>
                                <li><a href="admin_electionScheduleList">Election Schedule</a></li>
                             </ul>
                        </div>
                    </li>
                    
                    <li class="sidebar-dropdown" id="resultLink" style="display:none;"><a href="#"><i class="fas fa-chart-pie"></i><span>Election Results</span></a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li><a href="admin_electionIslandResult.php">All Island Results</a></li>
                                <li><a href="admin_electionDistrictResult.php">District Results</a></li>
                                <li><a href="admin_electionDivisionResult.php">Division Results</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- sidebar-menu  -->
        </div>
        <!-- sidebar-content  -->


    </nav>
</html>