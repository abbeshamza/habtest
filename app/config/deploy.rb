set :application, "TestAutomation By Fondative"
set :domain,      "192.168.7.186"
set :user,        "hab"

set :deploy_to,   "/public_html/testAutomation.Api/build"
ssh_options[:forward_agent] = true
set :app_path,    "app"
set :repository, 'git@github.com:abbeshamza/habtest.git'
set :use_sudo, false

set :ssh_options, { :forward_agent => true, :port => 4321 }
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3


# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

