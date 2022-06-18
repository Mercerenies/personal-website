#!/usr/pkg/bin/ruby
#
# great_mech_war.cgi
#

require 'cgi'
require 'securerandom'
require 'json'
require 'digest'

def read_data_file
  File.open("data.json", "r") do |f|
    f.flock(File::LOCK_SH)
    JSON.parse(f.read)
  end
end

def write_data_file(json)
  File.open("data.json", File::RDWR | File::CREAT, 0600) do |f|
    f.flock(File::LOCK_EX)
    f.rewind
    f.write(json.to_json)
    f.flush
    f.truncate(f.pos)
  end
end

def read_then_write_data_file(&block)
  File.open("data.json", File::RDWR | File::CREAT, 0600) do |f|
    f.flock(File::LOCK_EX)
    f.rewind
    result = block.call JSON.parse(f.read)
    f.rewind
    f.write(result.to_json)
    f.flush
    f.truncate(f.pos)
  end
end

secret_key = "!! SECRET KEY GOES HERE !!"

request_body = $stdin.read

if ENV['REQUEST_METHOD'] == "POST"
  ENV['REQUEST_METHOD'] = "GET" # Shush yourself, I know it's evil to do this.
end
cgi = CGI.new
query = cgi.query_string
query = query.gsub(/&hash=.*$/, "")
hash = Digest::MD5.hexdigest(query + secret_key)
if hash != cgi['hash']
  cgi.out { "failure to authenticate" }
  exit
end

cgi.out(content_type="application/json") do
  json = {}
  case cgi['action']
  when 'ping'
    json['pong'] = 'pong'
  when 'request-id'
    json['id'] = SecureRandom::uuid
  when 'full-list'
    data = read_data_file
    json['players'] = data['players']
  when 'upload'
    body = JSON.parse(request_body)
    id = body["id"]
    read_then_write_data_file do |data|
      found = false
      data['players'].map! { |x|
        if x['id'] == id
          found = true
          body
        else
          x
        end
      }
      if not found
        data['players'] << body
      end
      data
    end
    json['result'] = 'ok'
  when 'query'
    data = read_data_file
    match = data['players'].detect { |x| x['id'] == cgi['id'] }
    if match
      json = match
    else
      json['result'] = 'no-match'
    end
  end
  json.to_json
end
