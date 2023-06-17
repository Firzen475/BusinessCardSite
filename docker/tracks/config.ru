# This file is used by Rack-based servers to start the application.

require ::File.expand_path('../config/environment',  __FILE__)
map '/tracks' do
  run Rails.application
end
#run Rails.application
