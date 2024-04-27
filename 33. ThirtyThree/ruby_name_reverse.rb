# Ruby program to accept first and last name from the user
# and print them in reverse order with a space between them

puts "Enter your first name: "
first_name = gets.chomp

puts "Enter your last name: "
last_name = gets.chomp

full_name = "#{last_name} #{first_name}"
puts "Your name in reverse order is: #{full_name}"


#to reverse whole
def reverse_string(string)
  return string.reverse
end

puts "Enter your first name: "
first_name = gets.chomp

puts "Enter your last name: "
last_name = gets.chomp

first_name_rev = reverse_string(last_name)
last_name_rev = reverse_string(first_name)
full_name = "#{first_name_rev} #{last_name_rev}"
puts "Your name in reverse order is: #{full_name}"
