map-reduce in ruby
=================

Writing map reduces in ruby to run under Hadoop.

Examples
--------

* [Counting Words]

-------------------

* Running locally without Apache Hadoop

You can test your maps/reduces on your shell prompt by just piping the source data from the source file to the map, sorting its output before piping it to the reduce.

````
cat data-file.txt | ruby map.rb | sort | ruby reduce.rb
````

* The output of a map

Each output of a map must always be on the format `key` `tab` `value` `newline`

    puts "#{key}\t#{value}"

