-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 01, 2019 at 11:02 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `resolution`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `category`
-- 

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` varchar(500) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`cat_name`),
  UNIQUE KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=30 ;

-- 
-- Dumping data for table `category`
-- 

INSERT INTO `category` VALUES (1, 'Microsoft Visual C++');
INSERT INTO `category` VALUES (10, 'VC++ .net 2005/10');

-- --------------------------------------------------------

-- 
-- Table structure for table `comments`
-- 

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL auto_increment,
  `user_id` varchar(500) collate latin1_general_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `query_id` int(11) NOT NULL,
  `comment` varchar(500) collate latin1_general_ci NOT NULL,
  `verified` tinyint(1) NOT NULL,
  PRIMARY KEY  (`com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=157 ;

-- 
-- Dumping data for table `comments`
-- 

INSERT INTO `comments` VALUES (155, '2', 1, 40, 'discussion', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `files`
-- 

CREATE TABLE `files` (
  `query_id` int(11) NOT NULL,
  `file_name` varchar(500) collate latin1_general_ci NOT NULL,
  `size` varchar(500) collate latin1_general_ci NOT NULL,
  `type` varchar(500) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`query_id`,`file_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `files`
-- 

INSERT INTO `files` VALUES (137, 'landing.php', '24111', 'application/octet-stream');
INSERT INTO `files` VALUES (136, 'key.php', '18454', 'application/octet-stream');
INSERT INTO `files` VALUES (0, 'index.php', '4265', 'application/octet-stream');

-- --------------------------------------------------------

-- 
-- Table structure for table `queries`
-- 

CREATE TABLE `queries` (
  `query_id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL,
  `query` longtext collate latin1_general_ci NOT NULL,
  `soln` longtext collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`query_id`,`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=138 ;

-- 
-- Dumping data for table `queries`
-- 

INSERT INTO `queries` VALUES (40, 1, 'Wincore.cpp Line 980', 'Temporary Logging in D Drive, some pcs will have only one Drive (C)');
INSERT INTO `queries` VALUES (2, 1, 'afx.inl Line No 122', 'Rebuild the workspace and try once');
INSERT INTO `queries` VALUES (3, 1, '"Please Enter a Number" warning in  EN_CHANGE handler', 'Remove UpdateData(TRUE)/FALSE in the handler or change the data type of the controls member variable (Value) to Cstring\r\n');
INSERT INTO `queries` VALUES (4, 1, 'Problem : File: Winocc.cpp     Line : 301', 'The pointer (handle to the control) passed in the ShowWindow function could be NULL.');
INSERT INTO `queries` VALUES (5, 1, 'DAMAGE after normal block (#122) at 0x00E43600', 'This problem arises when you try to deallocate or free the memory, which is not allocated. \r\nOr \r\nYou are trying to de-allocate twice\r\n\r\nFind out whether the destructor of any class is getting called at the last which is actually not existing (memory is allocated) .. Find out in AddNewMessages() function in msgdriver.cpp (preferably).');
INSERT INTO `queries` VALUES (6, 1, 'dlgdata.cpp Line no 43', 'This problem arises if the libraries related to some of the controls such as Flexgrid are not registered. \r\nFor ex in GGVision MsflexGrid is used. msflxgrd.ocx library needs to be registered.\r\n\r\nTo register the same, use the following command:\r\nregsvr32 "C:\\WINDOWS\\system32\\msflxgrd.ocx"\r\n\r\nTo un-register the library use the following command:\r\nregsvr32 /u "C:\\WINDOWS\\system32\\msflxgrd.ocx"\r\n\r\n\r\nProblem 6 In Windows 7  & Windows Vista:\r\n\r\n\r\nIf you encounter the following messages\r\n"The module msflxgrd.ocx was loaded but the call to DllRegisterServer failed with error code 0x8002801c."\r\n\r\nSolution:\r\nIt may be because you did not run as administrator.\r\n\r\n1) Download "msflxgrd.ocx" from Easy-PC website.\r\nhttp://www.numberone.com/supporttools.asp\r\n2) Copy the file "msflxgrd.ocx" to c:\\Windows\\SysWOW64\\\r\n2) Register this "msflxgrd.ocx" to the operating system\r\nreference: http://www.numberone.com/faq.aspx?KB020026\r\na) Click Windows7 start button on the lower left corner of your screen\r\nb) In the "search programs and files" box, type in "cmd"\r\nc) The cmd program will be listed on top.\r\nd) Right click the shortcut to cmd program for the context menu, and click "Run as administrator"\r\ne) Change directory to c:\\Windows\\SysWOW64\\, type "cd \\Windows\\SysWOW64\\" then Enter.\r\nf) Type "REGSVR32 MSFLXGRD.OCX" then Enter.\r\ng) You should see the following message "DllRegisterServer in MSFLXGRD.OCX succeeded".\r\n');
INSERT INTO `queries` VALUES (7, 1, 'This problem may arise because some of the PC or system may have not registered  all the MFC related DLL.', 'In workspace of the respective GUI. Go to Project properties setting and check the configuration properties. This problem may arise due to  EXE build in "Use MFC in a Shared DLL". Change this configuration to "Use MFC in a Static Library" can solve this problem.\r\n\r\n\r\nP7:Linking...\r\nnafxcwd.lib(dllmodul.obj) : error LNK2005: _DllMain@12 already defined in LIBCMTD.lib(dllmain.obj)\r\nnafxcwd.lib(dllmodul.obj) : warning LNK4006: _DllMain@12 already defined in LIBCMTD.lib(dllmain.obj); second definition ignored\r\n   Creating library Debug/PraimApi.lib and object Debug/PraimApi.exp\r\nDebug/PraimApi.dll : fatal error LNK1169: one or more multiply defined symbols found\r\nError executing link.exe.\r\n\r\nPraimApi.dll - 2 error(s), 1 warning(s)');
INSERT INTO `queries` VALUES (8, 1, 'The accelerator key doesn''t work or it is not responding.', 'Clear the registry.\r\n\r\nThe procedure to clear the registry is explained with the following scenario.\r\n\r\nScenario(Example): In IRNSSRR GUI the accelerator key Ctrl+Alt+shift+D is used to enable parameter logging. On using the accelerator key if the parameter logging is not enabled, then perform the following steps.\r\n\r\nStep 1: select Run from the menu\r\nStep 2: Run regedit\r\nStep 3: Deleting the registry After deleting the registry, you can run the GUI and use the accelerator key. \r\n\r\nSuggestion to avoid this problem.\r\n\r\nFor every release we can change the registry name with the following syntax\r\n\r\nSyntax: Projectname_VersionNumber\r\nEg: IRNSSRR_V1.02,IRNSSRR_V1.03\r\n\r\nThis can be done as follows:\r\nStep 1: In the Application class of the Project, InitInstance function find the SetRegistryKey(Projectname_VersionNumber) function and change the registry name.\r\n\r\nEg:SetRegistryKey(_T("IRNSSRRGUI"));\r\n\r\n');
INSERT INTO `queries` VALUES (9, 1, 'GUI crashes and opening Rawdata.log gives a sharing violation error.', 'Kill all the processes with the name drwatson or something like this in the task manager after killing the exe of GUI in task manager.\r\nYou cann also look at the screen shot.');
INSERT INTO `queries` VALUES (10, 10, 'Debugging the source (Created using Empty Project option)', 'By default user will not be able to debug the project created using EmpyProject option. \r\nIn-order to overcome this issue follow the steps below\r\n\r\nOption 1:\r\nEnsure You are not trying to debug a release build.  Make sure that your Solution Configuration Dropdown box is set to "Debug" and not "Release".  You can find the Solution Configuration dropdown on the "Standard" Toolbar.  Try debugging again.\r\n\r\nOption 2:\r\nIf you are using the Debug Configuration, as described above, then debug information has probably been disabled in the Project Settings.  To fix this, \r\na. Click the Project menu and then select the " Properties..." item.  Expand the "C/C++" Tree and select the "General" node.  Ensure that "Debug Information Format" is set to either "Program Database (/Zi)" or "Program Database for Edit & Continue (/ZI)".  (Figure 2)\r\nb. Next, click the "Optimization" node.  Ensure that "Optimization" is set to "Disabled (/Od)".  (Figure 3)\r\nc. Click on Linker node and Select Debugging tab, Ensure Generate Debug Info is â€œYes (/DEBUG)â€ (figure 4)');
INSERT INTO `queries` VALUES (11, 10, 'To change the Default Environment Setting', '1.Select the Import and Export Setting from Tool menubar.\r\n2.Click the Reset all settings option from the dialog and click Next button.\r\n3. Then click on No, just reset settings, overwriting my current settings option and click Next button.\r\n4.Select the required Settings from the dialog and click on Finish button. Then restart the framework to have the new settings.');
INSERT INTO `queries` VALUES (12, 10, 'AfxBeginthread with class member controlling function ', 'Inoder to convert the class member function as a thread procedure follow these steps:\r\n\r\na) Declare the thread function as static in the Class \r\n\r\nFor ex:\r\nclass CSimDLLApp : public CWinApp\r\n{\r\npublic:\r\n	/* attributes */\r\n	â€¦.\r\n static UINT GpsDataTxThread (LPVOID pParam);	\r\n	. . . \r\n}\r\n\r\nb) Define the function without static keyword  as shown below\r\n\r\nUINT CSimDLLApp::GpsDataTxThread(LPVOID pParam)\r\n{\r\n	while(1)	\r\n	{\r\n		CSimDLLApp* pThis = reinterpret_cast <CSimDLLApp*>(pParam);\r\n\r\n. . . .\r\n\r\n}\r\n}\r\n\r\nc) Invokethe thread procedure using AfxBeginThread in the following manner\r\n\r\nThreadInitFunction()\r\n{\r\n		. . . \r\n	/* Invoke the threads */	\r\n	gpsdatatx_thread.pWin_thread = AfxBeginThread(&CSimDLLApp::GpsDataTxThread,NULL,0,0,CREATE_SUSPENDED,NULL); /* m_gpsinstdata - output structure */\r\n\r\n. . . \r\n\r\n}\r\n');
INSERT INTO `queries` VALUES (13, 10, 'Data validation of controls in property pages', 'Any control''s data validation that  needs to be carried out  in a property pages should be implemented in OnKillActive() member function of a particular property page\r\n\r\nFor Eg:\r\n\r\nBOOL CReplayPage::OnKillActive()\r\n{\r\n	\r\nif(m_strReplayFilePath == _T(""))\r\n	{\r\n\r\n	AfxMessageBox(_T(" Any msg to indicate the user has not given 						input"));\r\n\r\n/* To set the focus on a particular control */\r\n\r\n	CEdit* edit = (CEdit*) GetDlgItem(IDEB_SOMEFILEPATH_ID);\r\n	edit->SetFocus();\r\n	return FALSE;\r\n\r\n\r\n	}\r\n		\r\n	return CMFCPropertyPage::OnKillActive();\r\n}\r\n\r\nWhere in this Eg.  null value validation for CMFCEditBrowse variable "m_strReplayFilePath"  is being carried out for a property page CReplayPage\r\n\r\nReference: http://msdn.microsoft.com/en-us/library/2122ct0z%28v=vs.80%29.aspx');
INSERT INTO `queries` VALUES (14, 10, 'LNK4098: LIBCMT conflicts with use of other libs', 'Solution:\r\n\r\ngo to the Linker settings for your Debug configuration and add "LIBCMT" to the Ignore Specific Library setting of the Input section(http://forum.libcinder.org/topic/visual-c-2010-express-error-lnk4098-libcmt-conflicts-with-use-of-other-libs) \r\n\r\nProcedure:\r\n\r\nClick the Project menu and then select the "<Your Project Name> Properties..." item. Expand the "Linker" Tree and select the "Input" node and add â€œLIBC;LIBCMT;%(IgnoreSpecificDefaultLibraries)â€ under â€œIgnore Specific Default Librariesâ€ ');
INSERT INTO `queries` VALUES (15, 10, 'Cannot start tool.\r\nError spawning ''vcspawn.exe''. The build could not be performed.', 'Create a Environment system variable "VCSPAWN" with value "C:\\program files\\Microsoft Visual Studio\\Common\\MSDev98\\Bin\\VCSPAWN.EXE"');
INSERT INTO `queries` VALUES (137, 1, 'wwwwwwwwww', 'wwwwwwwwwwww');
INSERT INTO `queries` VALUES (136, 1, 'q', '');
INSERT INTO `queries` VALUES (135, 1, 'pppppppppppp', 'pppppppppppp');
INSERT INTO `queries` VALUES (134, 1, 'aqqqqqqqqqqqqqqqq', 'qqqqqqqqqqqqqq');
INSERT INTO `queries` VALUES (132, 1, 'wincore', '');
INSERT INTO `queries` VALUES (133, 1, 'aaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaa');

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `id` varchar(500) collate latin1_general_ci NOT NULL,
  `password` varchar(500) collate latin1_general_ci NOT NULL,
  `privilege` varchar(500) collate latin1_general_ci NOT NULL,
  `email` varchar(500) collate latin1_general_ci NOT NULL,
  `phone` varchar(500) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `password` (`password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `user`
-- 

INSERT INTO `user` VALUES ('1', 'c4ca4238a0b923820dcc509a6f75849b', 'admin', '0718shimona@gmail.com', '2');
INSERT INTO `user` VALUES ('2', 'c81e728d9d4c2f636f067f89cc14862c', 'regular', 'shimona@live.in', '2');
