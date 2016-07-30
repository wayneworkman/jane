dots() {
    local pad=$(printf "%0.1s" "."{1..70})
    printf " * %s%*.*s" "$1" 0 $((70-${#1})) "$pad"
    return 0
}
banner() {

clear
echo "        888888                            ";
echo "          \"88b                            ";
echo "           888                            ";
echo "           888  8888b.  88888b.   .d88b.  ";
echo "           888     \"88b 888 \"88b d8P  Y8b ";
echo "           888 .d888888 888  888 88888888 ";
echo "           88P 888  888 888  888 Y8b.     ";
echo "           888 \"Y888888 888  888  \"Y8888  ";
echo "         .d88P                            ";
echo "       .d88P\"                             ";
echo "      888P\"                               ";
echo
echo
echo "   A free and open account provisioning tool."
echo
echo
echo
}




