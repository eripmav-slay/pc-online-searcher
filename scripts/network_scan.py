# scripts/network_scan.py
import subprocess
import sys
import json
import re

def get_ip_from_mac(mac_address):
    try:
        output = subprocess.check_output(["arp", "-a"], universal_newlines=True)
        for line in output.splitlines():
            if mac_address.lower() in line.lower():
                match = re.search(r'(\d+\.\d+\.\d+\.\d+)', line)
                if match:
                    return match.group(1)
    except Exception as e:
        print(f"Error in get_ip_from_mac: {e}")
    return None

def check_ping(ip_address):
    try:
        return subprocess.call(["ping", "-n", "1", ip_address], stdout=subprocess.PIPE) == 0
    except Exception as e:
        print(f"Error in check_ping: {e}")
        return False

def scan_macs(mac_addresses):
    results = []
    for mac in mac_addresses:
        ip_address = get_ip_from_mac(mac)
        count = 0
        if ip_address and check_ping(ip_address):
            status = "使用中"
            count += 1
        else:
            status = "空き"
        results.append({"mac_address": mac, "ip_address": ip_address, "status": status, "count": count})
    return results

if __name__ == "__main__":
    mac_addresses = sys.argv[1:]
    results = scan_macs(mac_addresses)
    print(json.dumps(results))
