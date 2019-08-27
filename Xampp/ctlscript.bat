@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist D:\Pino\ProgIII\Xampp\hypersonic\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\server\hsql-sample-database\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\ingres\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\ingres\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\mysql\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\mysql\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\postgresql\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\postgresql\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\apache\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\apache\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\openoffice\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\openoffice\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\apache-tomcat\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\apache-tomcat\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\resin\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\resin\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\jboss\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\jboss\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\jetty\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\jetty\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\subversion\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist D:\Pino\ProgIII\Xampp\lucene\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\lucene\scripts\ctl.bat START)
if exist D:\Pino\ProgIII\Xampp\third_application\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist D:\Pino\ProgIII\Xampp\third_application\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\third_application\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\lucene\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist D:\Pino\ProgIII\Xampp\subversion\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\subversion\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\jetty\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\jetty\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\hypersonic\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\jboss\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\jboss\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\resin\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\resin\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT D:\Pino\ProgIII\Xampp\apache-tomcat\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\openoffice\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\openoffice\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\apache\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\apache\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\ingres\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\ingres\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\mysql\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\mysql\scripts\ctl.bat STOP)
if exist D:\Pino\ProgIII\Xampp\postgresql\scripts\ctl.bat (start /MIN /B D:\Pino\ProgIII\Xampp\postgresql\scripts\ctl.bat STOP)

:end

