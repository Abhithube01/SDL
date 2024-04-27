#gem install mail

# send_email.rb

require 'mail'

def send_email
  options = {
    :address              => "smtp.gmail.com",
    :port                 => 587,
    :user_name            => '//put sender mail here ',
    :password             => '//put receiver password here',
    :authentication       => 'plain',
    :enable_starttls_auto => true
  }

  Mail.defaults do
    delivery_method :smtp, options
  end

  mail = Mail.new do
    from     '//put sender mail here'
    to       '//put receiver mail here '
    subject  'Test Email'
    body     'This is a test email sent from Ruby.'
  end

  mail.deliver!
  puts 'Email sent successfully!'
rescue => e
  puts "Error sending email: #{e.message}"
end

send_email
